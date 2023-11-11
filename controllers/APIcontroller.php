<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIcontroller {

    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
        
    }

    public static function guardar() {
        

        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        
        $id = $resultado['id'];

        

        //Almacena los servicios junto al Id de cada cita
        $idServicios = explode(",", $_POST['servicios'] );
        
        foreach($idServicios as $idServicio) {
            
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            
            $citaServicio =  new CitaServicio($args);
            $citaServicio->guardar();
        }
        //Continua y returna la respuesta de si se guardo o no la cita
        $respuesta = [
            'resultado' => $resultado
        ];
        
        echo json_encode($respuesta);
    
    }
    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}