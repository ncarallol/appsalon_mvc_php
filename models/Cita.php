<?php

namespace Model;

class Cita extends ActiveRecord {
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'hora' , 'fecha', 'usuarioId', 'precio'];

    public $id;
    public $hora;
    public $fecha;
    public $usuarioId;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}