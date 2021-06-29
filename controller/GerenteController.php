<?php

class GerenteController
{
    private $GerenteModel;
    private $render;

    public function __construct($GerenteModel, $render)
    {
        $this->GerenteModel = $GerenteModel;
        $this->render = $render;
    }


    public function execute()
    {
        if ($this->validarSesion() == true) {

            echo $this->render->render("view/gerenteView.mustache");

        } else {
            header("location:/login");
        }
    }

    public function validarSesion()
    {
        $sesion = $_SESSION["Usuario"];

        if ($sesion == null || $sesion = '' || !isset($sesion)) {
            return false;
        } else {

            return true;
        }
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("location:/login");
    }

}
