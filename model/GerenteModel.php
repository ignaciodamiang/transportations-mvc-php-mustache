<?php

class GerenteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarViaje($ciudad_origen, $ciudad_destino, $fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $tiempo_estimado, $tiempo_real, $tipo_carga, $km_previsto, $km_reales, $desviacion, $posicion_gps, $combustible_estimado, $combustible_real, $id_vehiculo, $id_usuario)
    {
        $sql = "INSERT INTO Viaje (ciudad_origen, ciudad_destino, fecha_inicio, hora_inicio, fecha_fin, hora_fin, tiempo_estimado, tiempo_real, tipo_carga, km_previsto, km_reales, desviacion, posicion_gps, combustible_estimado, combustible_real, id_vehiculo, id_usuario)
VALUES( '$ciudad_origen', '$ciudad_destino', '$fecha_inicio', '$hora_inicio', '$fecha_fin', '$hora_fin', '$tiempo_estimado', '$tiempo_real', '$tipo_carga', '$km_previsto', '$km_reales', '$desviacion', '$posicion_gps', '$combustible_estimado', '$combustible_real', '$id_vehiculo', '$id_usuario')";

        $this->database->query($sql);


    }

}