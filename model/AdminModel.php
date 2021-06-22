<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarios(){
        return $this->database->query("SELECT * FROM usuario");
    }

    public function getUsuariosSinRol(){
        $sql = "SELECT * FROM usuario WHERE id_tipoUsuario IS NULL";
        $consulta = $this->database->query($sql);
        if(sizeof($consulta)!=0){
            return $consulta;
        } else
        return false;
    }

    public function getUsuarioPorId($id){
        $sql = "SELECT * FROM usuario where id = " . $id;
        return $this->database->query($sql);
    }

    public  function getAsignarNuevoRol($idRol , $idUsuario){

        $sql= " UPDATE Usuario SET id_tipoUsuario =$idRol WHERE id= $idUsuario";
        return $this->database->query($sql);

    }
}