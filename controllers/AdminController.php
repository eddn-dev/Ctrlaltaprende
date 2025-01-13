<?php
namespace Controllers;

use MVC\Router;

class AdminController {
public static function admin(Router $router) {
        $router->render('admin/admin', [
        ]);
    }
}