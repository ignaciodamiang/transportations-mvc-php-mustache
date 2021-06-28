<?php

class AdminController
{
    private $AdminModel;
    private $render;

    public function __construct($AdminModel, $render)
    {
        $this->AdminModel = $AdminModel;
        $this->render = $render;
    }


    public function execute()
    {
        $datas = array("usuariosSinRol" => $this->AdminModel->getUsuariosSinRol(), "todosLosVehiculos" => $this->AdminModel->getVehiculos());
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

    public function darRol()
    {
        $idRol = $_POST['Rol'];
        $idUsuario = $_POST['id'];
        $this->AdminModel->getAsignarNuevoRol($idRol, $idUsuario);
        header("location:/admin");
        exit();
    }

    public function registrarVehiculo()
    {
        /*$modelo = $_POST["modelo"];
        $marca = $_POST["marca"];
        $numeroMotor = $_POST["NumeroMotor"];
        
        $año_fabricacion = $_POST["año_fabricacion"];
        $estado = $_POST["estado"];
        $kilometraje = $_POST["kilometraje"];*/
        $patente = $_POST["patente"];
        $tipoVehiculo = $_POST["tipoVehiculo"];


        if (!$this->AdminModel->getValidarVehiculo($patente)) {
            $this->AdminModel->registrarVehiculo($patente, $tipoVehiculo);
            header("location: ../admin?vehiculoRegistrado");
        } else {

            header("location: ../admin?vehiculoNoRegistrado");
        }
    }


}
