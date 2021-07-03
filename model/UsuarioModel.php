<?php


class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getRolUsuario($email){

        $sql = "SELECT id_tipoUsuario  FROM Usuario WHERE email like '$email'";

        $resultado["rol"]= $this->database->query($sql);
        return $resultado["rol"]["0"]["id_tipoUsuario"];
    }

    public function getIdUsuario($email){

        $sql = "SELECT id FROM Usuario WHERE email like '$email'";

        $resultado["idUsuario"]= $this->database->query($sql);
        return $resultado["idUsuario"]["0"]["id"];
    }
}