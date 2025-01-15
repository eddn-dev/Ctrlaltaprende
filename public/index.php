<?php 

session_start();
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\ForoController;
use Controllers\PerfilController;
use Controllers\SiteController;

$router = new Router();

// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//Ruta de sitios
$router->get('/', [SiteController::class, 'inicio']);
$router->get('/content', [SiteController::class, 'content']);


$router->get('/foro', [ForoController::class, 'foro']);
$router->post('/foro', [ForoController::class, 'crear']);
$router->get('/foro/publicacion', [ForoController::class, 'post']);
$router->post('/foro/publicacion', [ForoController::class, 'post']);

$router->get('/foro/editar', [ForoController::class, 'editar']);
$router->post('/foro/editar', [ForoController::class, 'editar']);

$router->get('/perfil', [PerfilController::class, 'perfil']);
$router->post('/perfil', [PerfilController::class, 'perfil']);


$router->get('/admin', [AdminController::class, 'admin']);

$router->comprobarRutas();