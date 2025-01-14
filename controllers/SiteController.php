<?php

namespace Controllers;

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
        $router->render('site/content', [
        ]);
    }
}