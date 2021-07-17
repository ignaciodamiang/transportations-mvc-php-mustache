<?php

class MecanicoController
{
    private $MecanicoModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($MecanicoModel, $render,$usuarioModel,$verificarRolModel)
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
            $idMecanico= $this->usuarioModel->getIdUsuario($sesion);

            $datas = array("vehiculosEnReparacion" => $this->MecanicoModel->getListaDeVehiculosEnReparacion($idMecanico),
                            "vehiculosEnViaje" => $this->MecanicoModel->getListaDeVehiculosEnViaje(),                        
                           );



            if($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esMecanico($tipoUsuario) ){
                  echo $this->render->render("view/mecanicoView.mustache",$datas);
            }

            else {
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

    public  function irProformaService(){
        $idService= $_POST["idService"];

        $data["service"]= $this->MecanicoModel->getservicePorId($idService);

        if ($data != null) {
            echo $this->render->render("view/partial/proformaService.mustache", $data);

        }else{
            header("location:/mecanico?noRedirecciono");
        }


    }


    public function proformaService(){
        $fecha = $_POST["fecha"];
        $costo = $_POST["costo"];
        $repuesto = $_POST["repuesto"];
        $idService = $_POST["idService"];

        $this->MecanicoModel->cargarService($fecha, $costo, $repuesto, $idService);      
        $this->MecanicoModel->vehiculoArreglado($idService);

        header("location:/mecanico?mensaje=VehiculoReparado");

    }

    public function irAInformarPosicion(){
        $idVehiculo = $_POST["idVehiculo"];
        $data["posicion"]= $this->MecanicoModel->InformarPosicion($idVehiculo);

        if ($data != null) {
            echo $this->render->render("view/partial/mapaVehiculoEnViaje.mustache", $data);

        }else{
            header("location:/mecanico?noRedirecciono");
        }
    }
}