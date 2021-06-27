<?php

class loginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function verificarUsuario($email, $contraseña)
    {
        $sql = "SELECT id FROM Usuario WHERE email like '$email' and contraseña like '$contraseña' ";

        if(!empty($this->database->query($sql))){
            return true;
        }
        else{
            return  false;
        }
    }



    public function verificarUsuarioConRol($email, $contraseña)
    {
        $this->verificarUsuario($email, $contraseña);
        if ($this->verificarUsuario($email, $contraseña)) {
            $sql = "SELECT id_tipoUsuario 
                    FROM Usuario 
                    WHERE email like '$email' and contraseña like '$contraseña' ";
            if (!empty($this->database->query($sql))) {
                return true;
            } else {
                return false;
            }

        }
    }
}
?>
