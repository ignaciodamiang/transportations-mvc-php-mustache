<?php

class MecanicoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getListaDeVehiculosEnReparacion(){
        $sql = "SELECT * FROM Vehiculo
                WHERE en_reparacion = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }
}