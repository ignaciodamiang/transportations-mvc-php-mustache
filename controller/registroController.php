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
        if (isset($_GET["mensaje"])) {

            $mensaje["mensaje"] = $_GET["mensaje"];
            echo $this->render->render("view/registro.mustache", $mensaje);
        } else {
            echo $this->render->render("view/registro.mustache");

        }
    }

    public function registrarUsuario()
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $legajo = $_POST["legajo"];
        $dni = $_POST["dni"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $tipo_licencia = $_POST["tipo_licencia"];
        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];


        if (!$this->registroModel->getValidarRegistro($dni, $legajo, $email)) {
            $this->registroModel->registrarUsuario($nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $email, $contraseña);
            header("location: ../login?mensaje=registrado");
        } else {

            header("location: ../registro?mensaje=yaExiste");

        }
    }


}

?>