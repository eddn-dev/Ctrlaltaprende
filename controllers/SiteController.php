<?php

namespace Controllers;

use Model\Materia;
use Model\Tema;
use Model\Unidad;
use Model\Usuario;
use MVC\Router;

class SiteController {
    public static function inicio(Router $router) {
        $router->render('site/inicio', [
        ]);
    }

    public static function foro(Router $router) {
        $router->render('site/foro', [
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        if(!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }
    
        $usuario = Usuario::find($_SESSION['id']);
        if(!$usuario) {
            header('Location: /');
            return;
        }
    
        // Detectar si tenemos ?edit_skills=1
        $editSkills = $_GET['edit_skills'] ?? null;
    
        // Convertir skills en array, si fuera CSV
        $skillsArray = [];
        if(!empty($usuario->skills)) {
            $skillsArray = explode(',', $usuario->skills);
        }
    
        // Renderizar la vista
        $router->render('site/perfil', [
            'titulo'       => 'Mi Perfil',
            'usuario'      => $usuario,
            'skills'       => $skillsArray,
            'edit_skills'  => $editSkills
        ]);
    }    

    public static function content(Router $router) {
        session_start();

        // 1) Obtener el id del tema actual de ?id=, o asumir 1 si no existe
        $temaId = $_GET['id'] ?? 1;

        // 2) Cargar todas las materias para el índice
        $materias = Materia::all('ASC'); 

        // 3) Estructurar Materia → Unidades → Temas
        foreach($materias as $materia) {
            // Unidades de esta materia
            $unidades = Unidad::whereArray([
                'materia_id' => $materia->id
            ]);

            foreach($unidades as $unidad) {
                // Temas de esta unidad
                $temas = Tema::whereArray([
                    'unidad_id' => $unidad->id
                ]);
                // Guardo la lista en ->temas
                $unidad->temas = $temas;
            }
            // Guardo la lista de unidades en ->unidades
            $materia->unidades = $unidades;
        }

        // 4) Localizar el tema actual en la BD
        $temaActual = Tema::find($temaId);
        // Manejar el caso en que no exista
        if(!$temaActual) {
            header('Location: /content?id=1');
            return;
        }

        // 5) Leer el archivo JSON definido por $temaActual->doc_ruta
        //    y parsear su contenido
        $contenido = [];
        if($temaActual->doc_ruta && file_exists($temaActual->doc_ruta)) {
            // Si la ruta existe, leemos el archivo
            $jsonFile = file_get_contents($temaActual->doc_ruta);
            // Decodificamos
            $contenido = json_decode($jsonFile, true);
            if(!is_array($contenido)) {
                $contenido = []; 
                // O podrías manejar un error si el JSON es inválido
            }
        }
        $router->render('site/content', [
            'temaId'    => $temaId,
            'materias'  => $materias,
            'contenido' => $contenido // Por si luego deseas renderizarlo en la vista
        ]);
    }
}