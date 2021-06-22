<?php

class registroController
{
    private $registroModel;
    private $render;

    public function __construct($registroModel, $render)
    {
        $this->registroModel = $registroModel;
        $this->render = $render;
    }

    public function execute()
    {
        $arrayVacio= array();
        echo $this->render->render("view/registro.php");
    }

    public function registrarUsuario()
    {
        $nombre = isset( $_POST["nombre"] ) ? $_POST["nombre"] : "null" ;
        $apellido =$_POST["apellido"];
        $legajo =$_POST["legajo"];
        $dni = $_POST["dni"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $tipo_licencia = $_POST["tipo_licencia"];
        $email = $_POST["email"];
        $contraseña =$_POST["contraseña"];


        if ($this->registroModel->registrarUsuario($nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia ,$email, $contraseña)) {

            echo $this->render->render("view/login.php");
        } else {

            echo $this->execute();

        }
    }


}

?>