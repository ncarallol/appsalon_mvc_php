<?php

namespace Model;

class Servicio extends ActiveRecord {

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'precio', 'nombre'];

    public $id;
    public $precio;
    public $nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->precio = $args['precio'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'] [] = 'El nombre es obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'] [] = 'El precio es obligatorio';
        }
        return self::$alertas;
    }
}