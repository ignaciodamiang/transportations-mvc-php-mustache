<?php


class VerificacionDeRolModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function esAdmin($id_tipoUsuario){
        if($id_tipoUsuario=="1"){
            return true;
        }
        return false;
    }
    public function esGerente($id_tipoUsuario){
        if($id_tipoUsuario=="2"){
            return true;
        }
        return false;
    }
    public function esChofer($id_tipoUsuario){
        if($id_tipoUsuario=="3"){
            return true;
        }
        return false;
    }
    public function esMecanico($id_tipoUsuario){
        if($id_tipoUsuario=="4"){
            return true;
        }
        return false;
    }
}