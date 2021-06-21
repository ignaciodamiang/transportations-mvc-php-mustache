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
        return $this->database->query("SELECT * FROM usuario WHERE id_tipoUsuario IS NULL");
    }

    public function getUsuarioPorId($id){
        $sql = "SELECT * FROM usuario where id = " . $id;
        return $this->database->query($sql);
    }
}