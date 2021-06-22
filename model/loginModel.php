<?php

class loginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerUsuarioParaLoguear($email, $contraseña)
    {
        $sql = "SELECT * FROM Usuario WHERE email like '$email' and contraseña like '$contraseña' ";
        return $this->database->query($sql);
    }
}

?>
