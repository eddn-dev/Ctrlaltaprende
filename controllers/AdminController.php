<?php
namespace Controllers;

use MVC\Router;

class AdminController {
    public static function admin(Router $router) {
        session_start();

        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {

            header('Location: /');
            return;
        }

        $router->render('admin/admin', []);
    }
}
