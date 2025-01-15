<?php

namespace Controllers;

use Model\Publicacion;
use Model\Comentario;
use Model\Usuario;
use MVC\Router;

class ForoController {
    public static function foro(Router $router) {

        // Verificar sesión
        $sesionIniciada = isset($_SESSION['id']);
        $usuario = null;
        if($sesionIniciada) {
            $usuario = Usuario::find($_SESSION['id']);
        }

        // Detectar si ?new=1 (para mostrar modal de nueva publicación)
        $newPostModal = isset($_GET['new']) && $_GET['new'] == 1;

        // 1. Cargar todas las publicaciones (orden descendente: más recientes primero)
        $publicaciones = Publicacion::all('DESC');

        // 2. Para cada publicacion, obtener info extra (usuario, conteo de comentarios)
        foreach($publicaciones as $post) {
            // a) Cargar su autor
            $autor = Usuario::find($post->usuario_id);
            $post->autor = $autor; // propiedad virtual
            // b) Contar comentarios (usando el método contarComentarios())
            $post->total_comentarios = $post->contarComentarios();

            // c) Opcional: Formatear la fecha
            if($post->fecha_creacion) {
                // Convierte a un formato 'd/m/Y H:i' o el que prefieras
                $post->fecha_formateada = date('d/m/Y H:i', strtotime($post->fecha_creacion));
            } else {
                $post->fecha_formateada = '';
            }
        }

        // Renderizar la vista
        $router->render('site/foro', [
            'titulo'         => 'Foro',
            'newPostModal'   => $newPostModal,
            'sesionIniciada' => $sesionIniciada,
            'usuario'        => $usuario,
            'publicaciones'  => $publicaciones
        ]);
    }

    // Método para crear la publicación (POST /foro/crear)
    public static function crear() {
        // Verificamos método POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debe existir sesión
            if(!isset($_SESSION['id'])) {
                header('Location: /login');
                return;
            }

            // Crear instancia con lo que venga de $_POST
            $publicacion = new Publicacion($_POST);
            $publicacion->fecha_creacion = date('Y-m-d H:i:s');
            $publicacion->usuario_id = $_SESSION['id'];

            // Validamos título y texto (lo esencial)
            $alertas = $publicacion->validar();
            if(!empty($alertas['error'])) {
                $_SESSION['alertas'] = $alertas;
                header('Location: /foro?new=1');
                return;
            }

            // 1) Guardamos la publicación (sin 'media' aún)
            //    para obtener su ID y crear la carpeta /forum/<ID>
            $resultado = $publicacion->guardar();
            if(!$resultado['resultado']) {
                $_SESSION['alertas']['error'][] = 'Error al guardar la publicación.';
                header('Location: /foro?new=1');
                return;
            }

            // Obtenemos el ID recién generado
            $publicacionId = $resultado['id'];

            // 2) Creamos la carpeta /forum/<ID> para almacenar todos los archivos
            $carpetaPublicacion = __DIR__ . "/../public/forum/" . $publicacionId . "/";
            if(!is_dir($carpetaPublicacion)) {
                mkdir($carpetaPublicacion, 0755, true);
            }

            // 3) Comenzamos a armar las entradas para ->media
            $mediaEntries = [];

            // A) Manejo del archivo principal en 'media' (si existe)
            if(!empty($_FILES['media']['tmp_name'])) {
                $nombreOriginal = $_FILES['media']['name'];
                // Detectamos extensión
                $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                // Nombre final, p.ej. 'main.ext'
                $fileName = "main." . $ext;

                // Movemos a /forum/<ID>/
                $rutaCompleta = $carpetaPublicacion . $fileName;
                move_uploaded_file($_FILES['media']['tmp_name'], $rutaCompleta);

                // Determinar si es imagen o file
                $extImg = ['jpg','jpeg','png','gif','webp'];
                if(in_array(strtolower($ext), $extImg)) {
                    // [image: forum/<ID>/main.jpg]
                    $mediaEntries[] = "[image: forum/{$publicacionId}/{$fileName}]";
                } else {
                    // [file: forum/<ID>/main.pdf], etc.
                    $mediaEntries[] = "[file: forum/{$publicacionId}/{$fileName}]";
                }
            }

            // B) Manejo de blocks_code[] (códigos)
            $blocksCode = $_POST['blocks_code'] ?? []; 
            $i = 1;
            foreach($blocksCode as $codeText) {
                $codeText = trim($codeText);
                if($codeText === '') continue;

                // Nombre => code<i>.txt
                $fileName = "code{$i}.txt";
                $rutaCompleta = $carpetaPublicacion . $fileName;
                file_put_contents($rutaCompleta, $codeText);

                // Generamos: [code: forum/<ID>/code<i>.txt]
                $mediaEntries[] = "[code: forum/{$publicacionId}/{$fileName}]";
                $i++;
            }

            // C) Manejo de blocks_images[] (imágenes extras)
            if(isset($_FILES['blocks_images'])) {
                $countImages = count($_FILES['blocks_images']['name']);
                for($j=0; $j < $countImages; $j++) {
                    $tmpName = $_FILES['blocks_images']['tmp_name'][$j] ?? null;
                    $origName = $_FILES['blocks_images']['name'][$j] ?? null;
                    if(!$tmpName || !$origName) continue;
                    if(!is_uploaded_file($tmpName)) continue;

                    $ext = pathinfo($origName, PATHINFO_EXTENSION);
                    $fileName = "img{$j}." . $ext;
                    $rutaCompleta = $carpetaPublicacion . $fileName;
                    move_uploaded_file($tmpName, $rutaCompleta);

                    // [image: forum/<ID>/img0.jpg]
                    $mediaEntries[] = "[image: forum/{$publicacionId}/{$fileName}]";
                }
            }

            // Unimos todas las entradas en una sola cadena
            $finalMediaString = implode(';', $mediaEntries);

            // 4) Actualizamos la publicación con ->media
            $publicacion->id    = $publicacionId; 
            $publicacion->media = $finalMediaString;
            // Hacemos un update
            $publicacion->guardar();

            // 5) Redirigir a /foro o a la propia publicación
            header('Location: /foro/publicacion?id='.$publicacionId);  // o => /foro/publicacion?id=$publicacionId
        }
    }

       // Controlador - método post()
    public static function post(Router $router) {
        session_start();

        // Si es POST => crear comentario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar sesión
            if(!isset($_SESSION['id'])) {
                header('Location: /login');
                return;
            }

            // ID de la publicación
            $idPublicacion = $_POST['publicacion_id'] ?? null;
            if(!$idPublicacion) {
                // fallback
                $idPublicacion = $_GET['id'] ?? null;
            }

            // Texto del comentario
            $textoComentario = $_POST['texto'] ?? '';

            // parent_comment_id (si es respuesta)
            $parentId = $_POST['parent_comment_id'] ?? null;
            // Forzar a null si está vacío
            if($parentId === '') {
                $parentId = 'NULL';
            }

            // Crear
            $nuevoComentario = new Comentario([
                'texto'            => $textoComentario,
                'usuario_id'       => $_SESSION['id'],
                'publicacion_id'   => $idPublicacion,
                'parent_comment_id'=> $parentId, // null si no existe
                'fecha_creacion'   => date('Y-m-d H:i:s')
            ]);

            // Validar
            $alertas = $nuevoComentario->validar();
            if(!empty($alertas['error'])) {
                $_SESSION['alertas'] = $alertas;
                header('Location: /foro/publicacion?id=' . $idPublicacion);
                return;
            }

            // Guardar
            $resultado = $nuevoComentario->guardar();

            // Redirigir
            header('Location: /foro/publicacion?id=' . $idPublicacion);
            return;
        }

        // Si es GET => mostrar la publicación
        $sesionIniciada = isset($_SESSION['id']);
        $usuario = $sesionIniciada ? Usuario::find($_SESSION['id']) : null;

        $newPostModal = isset($_GET['new']) && $_GET['new'] == 1;
        $id = $_GET['id'] ?? null;
        if(!$id) {
            header('Location: /foro');
            return;
        }

        $publicacion = Publicacion::find($id);
        if(!$publicacion) {
            header('Location: /foro');
            return;
        }

        // Autor
        $autor = Usuario::find($publicacion->usuario_id);
        $publicacion->autor = $autor;
        $publicacion->fecha_formateada = $publicacion->fecha_creacion 
            ? date('d/m/Y H:i', strtotime($publicacion->fecha_creacion)) 
            : '';

        // Comentarios en forma de árbol
        $comentariosTree = Comentario::findByPublicacionAsTree($publicacion->id);

        // Enriquecer con autor y fecha
        function enrichComments(&$comments) {
            foreach($comments as &$coment) {
                $coment->autor = Usuario::find($coment->usuario_id);
                $coment->fecha_formateada = $coment->fecha_creacion
                    ? date('d/m/Y H:i', strtotime($coment->fecha_creacion))
                    : '';
                if(isset($coment->children) && !empty($coment->children)) {
                    enrichComments($coment->children);
                }
            }
        }
        enrichComments($comentariosTree);

        $router->render('site/post', [
            'titulo'        => 'Detalle de la Publicación',
            'sesionIniciada'=> $sesionIniciada,
            'usuario'       => $usuario,
            'newPostModal'  => $newPostModal,
            'publicacion'   => $publicacion,
            'comentarios'   => $comentariosTree 
        ]);
    }

    public static function editar(Router $router) {
        session_start();

        // 1) Verificar sesión
        if(!isset($_SESSION['id'])) {
            header('Location: /login');
            return;
        }
        $usuario = Usuario::find($_SESSION['id']);

        // 2) Obtener el ID de la publicación desde ?id= en la URL
        $id = $_GET['id'] ?? null;
        if(!$id) {
            header('Location: /foro');
            return;
        }

        // 3) Buscar la publicación en la BD
        $publicacion = Publicacion::find($id);
        if(!$publicacion) {
            header('Location: /foro');
            return;
        }

        // 4) Verificar que el usuario logueado es el autor de la publicación
        if($publicacion->usuario_id !== $usuario->id) {
            header('Location: /foro');
            return;
        }

        // 5) Si es POST => Procesar actualización
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar los datos basados en $_POST
            $publicacion->sincronizar($_POST);
            
            // Validar
            $alertas = $publicacion->validar();
            if(!empty($alertas['error'])) {
                $_SESSION['alertas'] = $alertas;
                header('Location: /foro/editar?id=' . $id);
                return;
            }

            // Carpeta
            $carpetaPublicacion = __DIR__ . "/../public/forum/" . $publicacion->id . "/";
            if(!is_dir($carpetaPublicacion)) {
                mkdir($carpetaPublicacion, 0755, true);
            }

            // =========== 1) Eliminar media existente ===========
            $removeMedia = $_POST['remove_media'] ?? [];
            $mediaEntries = [];
            if(!empty($publicacion->media)) {
                $mediaEntries = explode(';', $publicacion->media);
                $mediaEntries = array_map('trim', $mediaEntries);
            }

            $removeSet = array_flip($removeMedia);
            $mediaEntries = array_filter($mediaEntries, function($entry) use ($removeSet) {
                if(preg_match('/^\[(.*?)\:\s*(.*?)\]$/', $entry, $matches)) {
                    $ruta = trim($matches[2]);
                    if(isset($removeSet[$ruta])) {
                        $rutaCompleta = __DIR__ . "/../public/" . $ruta;
                        if(is_file($rutaCompleta)) {
                            unlink($rutaCompleta);
                        }
                        return false; 
                    }
                }
                return true;
            });

            // =========== 3a) Manejo de update_code[] ===========
            $updateCodeItems = $_POST['update_code'] ?? [];
            foreach($updateCodeItems as $rutaRel => $nuevoContenido) {
                $expectedPrefix = "forum/{$publicacion->id}/";
                // Verificamos que empiece con la carpeta "forum/<id>/" por seguridad
                if(strpos($rutaRel, $expectedPrefix) !== 0) {
                    continue; 
                }
                $rutaCompleta = __DIR__ . "/../public/" . $rutaRel;
                // Validamos que sea un archivo codeX.txt
                if(is_file($rutaCompleta) && preg_match('/code\d+\.txt$/i', $rutaRel)) {
                    $nuevoContenido = trim($nuevoContenido);
                    file_put_contents($rutaCompleta, $nuevoContenido);
                }
            }

            // =========== 2) Manejo de nuevo archivo principal (media) ===========
            if(!empty($_FILES['media']['tmp_name'])) {
                $nombreOriginal = $_FILES['media']['name'];
                $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                $fileName = "main." . $ext;

                $rutaCompleta = $carpetaPublicacion . $fileName;
                move_uploaded_file($_FILES['media']['tmp_name'], $rutaCompleta);

                $extImg = ['jpg','jpeg','png','gif','webp'];
                if(in_array(strtolower($ext), $extImg)) {
                    $mediaEntries[] = "[image: forum/{$publicacion->id}/{$fileName}]";
                } else {
                    $mediaEntries[] = "[file: forum/{$publicacion->id}/{$fileName}]";
                }
            }

            // =========== 3) Manejo de blocks_code[] (nuevos) ===========
            $blocksCode = $_POST['blocks_code'] ?? [];
            $maxCodeIndex = 0;
            foreach($mediaEntries as $m) {
                if(preg_match('/code(\d+)\.txt/i', $m, $mm)) {
                    $idx = intval($mm[1]);
                    if($idx > $maxCodeIndex) {
                        $maxCodeIndex = $idx;
                    }
                }
            }

            $i = $maxCodeIndex + 1; 
            foreach($blocksCode as $codeText) {
                $codeText = trim($codeText);
                if($codeText === '') continue;

                $fileName = "code{$i}.txt";
                $rutaCompleta = $carpetaPublicacion . $fileName;
                file_put_contents($rutaCompleta, $codeText);

                $mediaEntries[] = "[code: forum/{$publicacion->id}/{$fileName}]";
                $i++;
            }

            // =========== 4) Manejo de blocks_images[] (nuevas) ===========
            if(isset($_FILES['blocks_images'])) {
                $maxImgIndex = 0;
                foreach($mediaEntries as $m) {
                    if(preg_match('/img(\d+)\./i', $m, $mm)) {
                        $idx = intval($mm[1]);
                        if($idx > $maxImgIndex) {
                            $maxImgIndex = $idx;
                        }
                    }
                }
                $j = $maxImgIndex + 1;

                $countImages = count($_FILES['blocks_images']['name']);
                for($k=0; $k < $countImages; $k++) {
                    $tmpName = $_FILES['blocks_images']['tmp_name'][$k] ?? null;
                    $origName = $_FILES['blocks_images']['name'][$k] ?? null;
                    if(!$tmpName || !$origName) continue;
                    if(!is_uploaded_file($tmpName)) continue;

                    $ext = pathinfo($origName, PATHINFO_EXTENSION);
                    $fileName = "img{$j}." . $ext;
                    $rutaCompleta = $carpetaPublicacion . $fileName;
                    move_uploaded_file($tmpName, $rutaCompleta);

                    $mediaEntries[] = "[image: forum/{$publicacion->id}/{$fileName}]";
                    $j++;
                }
            }

            // Unir
            $finalMediaString = implode(';', $mediaEntries);
            $publicacion->media = $finalMediaString;

            // Guardar
            $resultado = $publicacion->guardar();
            if(!$resultado) {
                $_SESSION['alertas']['error'][] = 'Hubo un error al actualizar la publicación.';
                header('Location: /foro/editar?id=' . $id);
                return;
            }

            header('Location: /foro/publicacion?id=' . $id);
            return;
        }

        // 6) Si es GET => Renderizar la vista "editar"
        $sesionIniciada = true; // ya validado antes
        $router->render('site/editar', [
            'titulo'        => 'Editar Publicación',
            'publicacion'   => $publicacion,
            'sesionIniciada'=> $sesionIniciada,
            'usuario'       => $usuario
        ]);
    }

}

