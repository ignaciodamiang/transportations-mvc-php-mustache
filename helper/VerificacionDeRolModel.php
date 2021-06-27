<?php


class VerificacionDeRolModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function esAdmin($id){
        if($id=='1'){
            return true;
        }
        return false;
    }
    public function esGerente($id){
        if($id=='2'){
            return true;
        }
        return false;
    }
    public function esChofer($id){
        if($id=='3'){
            return true;
        }
        return false;
    }
    public function esMecanico($id){
        if($id=='4'){
            return true;
        }
        return false;
    }
}