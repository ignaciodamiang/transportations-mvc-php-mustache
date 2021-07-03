<?php

class ChoferModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getViajeEnCurso($idChofer){
        $sql = "SELECT * FROM Viaje WHERE id_usuario = '$idChofer' and viaje_enCurso = 1";
        $consulta = $this->database->query($sql);
        return $consulta;
    }



}