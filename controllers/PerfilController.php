<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class PerfilController {
    public static function perfil(Router $router) {
    
        // ID por GET o Session
        $id = $_GET['id'] ?? $_SESSION['id'];
    
        $usuario = Usuario::find($id);
        if(!$usuario) {
            header('Location: /');
            return;
        }

        $puedeEditar = ($id == $_SESSION['id']);

        $edit_skills = $_GET['edit_skills'] ?? null;
        $edit_photo  = $_GET['edit_photo']  ?? null;

        // Por defecto, array vacío
        $skillsArray = [];

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Convertir CSV -> array de skills
            if($usuario->skills) {
                $skillsArray = explode(',', $usuario->skills);
            }
        } else {
            // POST => Actualizar
            if(!$puedeEditar) {
                // No puede editar si no es el dueño
                header('Location: /perfil?id=' . $id);
                return;
            }

            // (A) Actualizar Skills
            if(isset($_POST['tags'])) {
                $usuario->skills = $_POST['tags'];
            }

            // (B) Actualizar Descripción (vía fetch)
            if(isset($_POST['description'])) {
                // Si deseas, limpias HTML o usas htmlspecialchars
                $desc = trim($_POST['description']);
                $usuario->descripcion = $desc;
                // Si se usa fetch, tal vez no rediriges aquí sino devuelves un "echo" a JS
            }

            // (C) Actualizar Foto
            if(isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['tmp_name'])) {
                // Verificar si había una foto anterior distinta a la predeterminada
                if($usuario->profile && $usuario->profile !== 'profile-default.avif') {
                    $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/profiles/' . $usuario->profile;
                    if(file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Generar un nombre único para la nueva foto
                $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
                $filename = md5( uniqid(rand(), true) ) . '.' . $ext;

                // Mover el archivo subido a la carpeta /profiles/
                $destino = $_SERVER['DOCUMENT_ROOT'] . '/profiles/' . $filename;
                move_uploaded_file($_FILES['profile_photo']['tmp_name'], $destino);

                // Asignar al usuario
                $usuario->profile = $filename;
            }

            $usuario->guardar();

            // Si la request vino de fetch, podrías:
            //   echo "OK"; die; // para no redirigir
            // En cambio, si es un form normal, rediriges:
            if(!isset($_POST['description'])) {
                // Redirigir solo si no es el fetch de descripción
                header('Location: /perfil?id=' . $id);
                return;
            } else {
                // fetch
                echo 'Descripción guardada';
                return;
            }
        }

        $router->render('site/perfil', [
            'usuario'     => $usuario,
            'skills'      => $skillsArray,
            'puedeEditar' => $puedeEditar,
            'edit_skills' => $edit_skills,
            'edit_photo'  => $edit_photo
        ]);
    }
}
