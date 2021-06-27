<?php

class loginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function verificarUsuario($email, $password)
    {
        $sql = "SELECT * FROM Usuario WHERE email like '$email' and contraseña like '$password' ";
        $resultado["lista"]=$this->database->query($sql);
        if(sizeof($resultado["lista"])>=1){
            return $this->database->query($sql);;
        }
        else{
            return  false;
        }
    }



    public function verificarUsuarioConRol($email, $password)
    {


        if ($this->verificarUsuario($email, $password)!= false) {

            $resultado["rol"]= $this->verificarUsuario($email, $password);


            if ($resultado["rol"]["0"]["id_tipoUsuario"]!= null) {
                return true;
            } else {
                return false;
            }

        }
        else{
            return false;
        }
    }
}
?>
