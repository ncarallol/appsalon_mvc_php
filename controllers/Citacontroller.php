<?php

namespace Controllers;

use MVC\Router;

class Citacontroller {
    public static function index(Router $router) {
        session_start();
        isAuth();
        
        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']

        ]);

    }
}