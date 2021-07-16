<?php

class MecanicoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getListaDeVehiculosEnReparacion($idMecanico){
        $sql = "select * 
                from services 
                inner join vehiculo on services.id_vehiculo = vehiculo.id
                where vehiculo.en_reparacion = 1 and services.id_usuario='$idMecanico'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }
}