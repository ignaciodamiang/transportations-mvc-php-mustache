<?php

class ChoferModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getViajeEnCurso($idChofer){
        $sql = "SELECT * FROM Viaje INNER JOIN TipoVehiculo ON Viaje.id_vehiculo = TipoVehiculo.id
                WHERE id_usuario = '3' and viaje_enCurso =0";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getEmpezarViaje($id_viaje,$latitud, $longitud,$fechaInicioReal,$horaInicioReal){
        $sql="UPDATE `transporteslamatanza`.`Viaje` 
                SET `latitud_inicio` = '$latitud', `longitud_inicio` = '$longitud' ,
                fecha_inicioReal='$fechaInicioReal', hora_inicio='$horaInicioReal',
                viaje_enCurso= true;
                WHERE (`id` = '$id_viaje')";
        $this->database->execute($sql);

    }



}