<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord {

    public static $tabla = 'usuarios';
    public static $columnasDB = ['id','nombre','apellido','telefono','email','password','token','confirmado','admin' ];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $password;
    public $token;
    public $confirmado;
    public $admin;

    public function __construct($args = []) {
    
    $this->id = $args['id'] ?? NULL;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->confirmado = $args['confirmado'] ?? 0;
    $this->admin = $args['admin'] ?? 0;

    }

    //Mensajes de validacion para creacion de la cuenta
    public function validarNuevacuenta() {
        if (!$this->nombre) {
            self::$alertas ['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas ['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas ['error'][] = 'El telefono es obligatorio';
        }
        if (!$this->password) {
            self::$alertas ['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6 ) {
            self::$alertas ['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;

    }
    public function validarLogin() {
        if (!$this->email) {
            self::$alertas ['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas ['error'][] = 'El password es obligatorio';
        }
        
        return self::$alertas;

    }
    public function validarEmail() {
        if (!$this->email) {
            self::$alertas ['error'][] = 'El email es obligatorio';
        }

        return self::$alertas;
    }
    

    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email='" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas ['error'][] = 'El ususario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken() {
        $this->token = uniqid();
    }
    public function verificarPasswordAndConfirmado($password) {
        $resultado = password_verify($password, $this->password);
       
        if($resultado && !$this->confirmado){
            self::$alertas ['error'] [] = 'Todavia no confirmas tu cuenta, revisa tu email';

        }  elseif(!$resultado && $this->confirmado) {
            self::$alertas ['error'] [] = 'Contraseña incorrecta';
        } else {
            return true;
        }
    }
    public function validarPassword() {
    if (!$this->password) {
        self::$alertas ['error'][] = 'El password es obligatorio';
    }
    if (strlen($this->password) < 6 ) {
        self::$alertas ['error'][] = 'El password debe contener al menos 6 caracteres';
    }

    return self::$alertas;

    }
}