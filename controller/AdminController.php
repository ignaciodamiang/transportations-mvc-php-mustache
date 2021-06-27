<?php

class AdminController
{
    private $adminModel;
    private $render;

    public function __construct($adminModel, $render)
    {
        $this->adminModel = $adminModel;
        $this->render = $render;
    }

    public function execute()
    {
        $data["usuariosSinRol"] = $this->adminModel->getUsuariosSinRol();
        if ($this->validarSesion() == true) {
            echo $this->render->render("view/admin/adminView.mustache", $data);
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

    public function darRol()
    {
        $idRol = $_POST['Rol'];
        $idUsuario = $_POST['id'];
        $this->adminModel->getAsignarNuevoRol($idRol, $idUsuario);
        header("location:/admin");
        exit();
    }
}