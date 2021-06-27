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
        return $this->database->query($sql);
    }
}