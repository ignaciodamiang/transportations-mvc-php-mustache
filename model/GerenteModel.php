<?php

class GerenteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarViaje($ciudad_origen, $ciudad_destino, $fecha_inicio,  $fecha_fin, $tiempo_estimado,  $tipo_carga, $km_previsto,  $combustible_estimado,  $id_vehiculo, $id_usuario)
    {

        $sql1 = "INSERT INTO Viaje (ciudad_origen, ciudad_destino, fecha_inicio,  fecha_fin,  tiempo_estimado,  tipo_carga, km_previsto, combustible_estimado, id_vehiculo, id_usuario)
VALUES( 
        '$ciudad_origen',
        '$ciudad_destino',
        '$fecha_inicio',        
        '$fecha_fin',       
        '$tiempo_estimado',       
        '$tipo_carga',
        '$km_previsto',        
        '$combustible_estimado',
        '$id_vehiculo',
        '$id_usuario'
        )";
        $this->database->execute($sql1);
    }

}