<?php

namespace Controllers;

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
        $router->render('site/perfil', [
        ]);
    }
}