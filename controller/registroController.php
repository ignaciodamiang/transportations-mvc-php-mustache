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
        echo $this->render->render("view/registro.php");
    }

    public function registrarUsuario()
    {
        $nombre = isset($_POST["nombre"]);
        $apellido = isset($_POST["apellido"]);
        $legajo = isset($_POST["legajo"]);
        $dni = isset($_POST["dni"]);
        $fecha_nacimiento = isset($_POST["fecha_nacimiento"]);
        $tipo_licencia = isset($_POST["tipo_licencia"]);
        $email = isset($_POST["email"]);
        $contraseña = isset($_POST["contraseña"]);


        if ($this->registroModel->registrarUsuario($nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia ,$email, $contraseña)) {

            echo $this->render->render("view/login.php");
        } else {

            echo $this->execute();

        }
    }


}

?>