<?php

class VehiculoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getVehiculos()
    {
        $sql="SELECT * FROM vehiculo";
        $consulta = $this->database->query($sql);
        return $consulta;
    }
}