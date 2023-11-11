<?php

namespace Controllers;

use Clases\Email;
use Model\ActiveRecord;
use Model\Usuario;
use MVC\Router;

class LoginController {
    
    public static function login(Router $router) {
        $alertas = [];
        $notificacion = $_GET['1'] ?? null;

        if ($notificacion === '') {
            Usuario::setAlerta('exito', 'La contraseña se reestablecio con exito');
        } 

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) {
                //Verificar que el email exista          

            $usuario = Usuario::where('email', $auth->email);
            
            if($usuario) {
                //verificar usuario
            if( $usuario->verificarPasswordAndConfirmado($auth->password) ) {

                session_start();

                $_SESSION['id'] = $usuario->id;
                $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                $_SESSION['email'] = $usuario->email;
                $_SESSION['login'] = true;

                //Redireccionar

                if($usuario->admin === '1') {
                    $_SESSION['admin'] = true;
                    header('Location: /admin');
                    
                } else {
                    header('Location: /citas');
                }
        }
                } else {
                    Usuario::setAlerta('error', 'email no encontrado');
                }        
                }
    }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'notificacion' => $notificacion

        ]);
    }
    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router) {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Verificar que se complete el campo
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            
            if(empty($alertas)) {
                $usuario = $auth->where('email',$auth->email);
                if($usuario && $usuario->confirmado === '1') {
                    $usuario->crearToken();
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Revisa tu email para verificar tu cuenta');

                    //Enviar email
                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);

                    $email->enviarRecuperar();
                    
                } else {
                    Usuario::setAlerta('error', "El email no se encuentra registrado o esta sin verificar");
                }
            }
        $alertas = Usuario::getAlertas();    
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide',[
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']) ?? null;
        $usuario = Usuario::where('token', $token );
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'token no valido');
            $error = true;
        }
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario->password = '';
        $usuario->password = $_POST['password'];
        $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
        
            $usuario->hashPassword();
            $usuario->token = null;
            $recuperarContraseña = true;
            $resultado = $usuario->guardar();
            
                if($resultado) {
                header('Location: /?' . $recuperarContraseña .'');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar',[
            'usuario' => $usuario,
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router) {

        $usuario = new Usuario();
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $usuario->sincronizar($_POST);
        $alertas = $usuario->validarNuevacuenta();

        if(empty($alertas)) {
            //Verificar si el usuario existe
            $resultado = $usuario->existeUsuario();
            if($resultado->num_rows) {
                $alertas = Usuario::getAlertas();
            } else {
                //hashear password
                $usuario->hashPassword();

                //Crear token 
                $usuario->crearToken();

                //Enviar Email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);

                $email->enviarConfirmacion();

                //Crear ek usuario

                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /mensaje');
                }

                debuguear($usuario);
                
            }

        }
        }
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }

    public static function confirmar(Router $router) {
        $alertas = [];

        $token = $_GET['token'];
        
        $usuario = Usuario::where('token', s($token));
        
        if(!$usuario) {

            $exito= null;
            Usuario::setAlerta('error','No se pudo realizar la autenticacion..intenta recuperar tu contraseña');

        } else {
            $exito = 1;
            Usuario::setAlerta('exito','Tu cuenta ha sido creada correctamente');

            
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();

        }
                
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas,
            'exito' => $exito


        ]);

    }
    public static function mensaje(Router $router) {

        $router->render('auth/mensaje',[

        ]);

    }
    

}