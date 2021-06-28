<?php

class VehiculoController
{

    private $VehiculoModel;
    private $render;

    public function __construct($VehiculoModel, $render)
    {
        $this->VehiculoModel = $VehiculoModel;
        $this->render = $render;
    }

    public function execute()
    {
        $datas["todosVehiculos"] = $this->VehiculoModel->getVehiculos();
        if ($this->validarSesion() == true) {
            echo $this->render->render("view/admin/adminView.mustache", $datas);
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