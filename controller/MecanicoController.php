<?php

class MecanicoController
{
    private $MecanicoModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($MecanicoModel, $render, $usuarioModel, $verificarRolModel)
    {
        $this->MecanicoModel = $MecanicoModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
    }


    public function execute()

    {


        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);
            $idMecanico = $this->usuarioModel->getIdUsuario($sesion);

            $datas = array("vehiculosEnReparacion" => $this->MecanicoModel->getListaDeVehiculosEnReparacion($idMecanico), "vehiculosEnViaje" => $this->MecanicoModel->getListaDeVehiculosEnViaje(), "url" => "../mecanico");

            $datas["rol"] = "Mecánico";
            $datas["iconoPrimerBoton"] = 'M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z';
            $datas["primerBoton"] = "Control de viajes";
            $datas["rutaPrimerBoton"] = "../mecanico";
            $datas["iconoSegundoBoton"] = 'M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z';
            $datas["segundoBoton"] = "Control services";
            $datas["rutaSegundoBoton"] = "../mecanico/services";
            $sesion = $_SESSION["Usuario"];
            $id = $this->usuarioModel->getIdUsuario($sesion);
            $this->usuarioModel->getNombreUsuario($id);
            $datas["nombre"] = $this->usuarioModel->getNombreUsuario($id);
            $datas["apellido"] = $this->usuarioModel->getApellidoUsuario($id);


            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esMecanico($tipoUsuario)) {
                echo $this->render->render("view/mecanicoView.mustache", $datas);
            } else {
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

    public function irProformaService()
    {
        $idService = $_POST["idService"];

        $datas["service"] = $this->MecanicoModel->getservicePorId($idService);

        if ($datas != null) {
            echo $this->render->render("view/partial/proformaService.mustache", $datas);

        } else {
            header("location:/mecanico?noRedirecciono");
        }


    }


    public function proformaService()
    {
        $fecha = $_POST["fecha"];
        $costo = $_POST["costo"];
        $repuesto = $_POST["repuesto"];
        $idService = $_POST["idService"];

        $this->MecanicoModel->cargarService($fecha, $costo, $repuesto, $idService);
        $this->MecanicoModel->vehiculoArreglado($idService);

        header("location:/mecanico?mensaje=VehiculoReparado");

    }

    public function irAInformarPosicion()
    {
        $idVehiculo = $_POST["idVehiculo"];
        $data["posicion"] = $this->MecanicoModel->InformarPosicion($idVehiculo);

        if ($data != null) {
            echo $this->render->render("view/partial/mapaVehiculoEnViaje.mustache", $data);

        } else {
            header("location:/mecanico?noRedirecciono");
        }
    }
}