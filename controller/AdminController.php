<?php

class AdminController
{
    private $verificarRolModel;
    private $AdminModel;
    private $usuarioModel;
    private $render;

    public function __construct($AdminModel, $render,$verificarRolModel,$usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
        $this->AdminModel = $AdminModel;
        $this->render = $render;
    }


    public function execute()
    {
        $datas = array("usuariosSinRol" => $this->AdminModel->getUsuariosSinRol(), "todosLosVehiculos" => $this->AdminModel->getVehiculos());
        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if($this->verificarRolModel->esAdmin($tipoUsuario)){
                echo $this->render->render("view/admin/adminView.mustache", $datas);
            }else{
                $this->cerrarSesion();
                header("location:/login");
            }
            

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
        $sesion = $_SESSION["Usuario"];

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

    public function irModificarVehiculo(){
        $id = $_POST["idVehiculo"];
        $patente = $_POST["patente"];
        $tipoVehiculo = $_POST["tipoVehiculo"];

        $data["vehiculo"] = $this->AdminModel->getVehiculosPorId($id);
        if ($data != null) {
            echo $this->render->render("view/partial/modificarVehiculoView.mustache", $data);

        }else{
            header("location:/admin?noRedirecciono");
        }
    }

    public function modificarVehiculo(){
        $id = $_POST["idVehiculo"];
        $patente = $_POST["patente"];
        $tipoVehiculo = $_POST["tipoVehiculo"];

        if(isset( $_POST["idVehiculo"]) && isset($_POST["patente"])){
            $id = $_POST["idVehiculo"];
            $patente = $_POST["patente"];
            $tipoVehiculo = $_POST["tipoVehiculo"];


            if ($this->AdminModel->getVehiculosPorId($id)) {
                $this->AdminModel->modificarVehiculo($id,$patente,$tipoVehiculo);
                header("location:/admin?vehiculoModificado");
            }else{
                header("location:/admin?errorAlmodificar");
            }
            
        }else{
            header("location:/admin?errorAlmodificar");
        }

    }

    public function BorrarVehiculo(){
        $idVehiculo = $_POST["idVehiculo"];


        if ($this->AdminModel->getVehiculosPorId($idVehiculo)) {
            $this->AdminModel->borrarVehiculo($idVehiculo);
            header("location: ../admin?vehiculoBorrado");
        }else{

            header("location: ../admin?vehiculoNoBorrado");
        }
    }
}
