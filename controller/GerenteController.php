<?php

class GerenteController
{
    private $GerenteModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($GerenteModel, $render,$verificarRolModel,$usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
        $this->GerenteModel = $GerenteModel;
        $this->render = $render;
    }


    public function execute()
    {
        $datas = array("todosLosVehiculos" => $this->GerenteModel->getVehiculos(), "todosLosChoferes" => $this->GerenteModel->getListaDeChoferes());

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esGerente($tipoUsuario) ){

                echo $this->render->render("view/gerenteView.mustache",$datas);
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

    public function registrarViaje()
    {
        $ciudad_origen = $_POST["ciudad_origen"];
        $ciudad_destino = $_POST["ciudad_destino"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $tiempo_estimado = $_POST["tiempo_estimado"];
        $tipo_carga = $_POST["tipo_carga"];
        $km_previsto = $_POST["km_previsto"];
        $combustible_estimado = $_POST["combustible_estimado"];
        $id_vehiculo = $_POST["id_vehiculo"];
        $id_usuario = $_POST["id_usuario"];
        $viaje_enCurso = false;



        $this->GerenteModel->registrarViaje( $ciudad_origen,
                                             $ciudad_destino,
                                             $fecha_inicio,
                                             $fecha_fin,
                                             $tiempo_estimado,
                                             $tipo_carga,
                                             $km_previsto,
                                             $combustible_estimado,
                                             $viaje_enCurso,
                                             $id_vehiculo,
                                             $id_usuario
                                             );
            header("location:/gerente?viajeRegistrado");
        }

    public function registrarVehiculo()
    {
        $patente = $_POST["patente"];
        $NumeroChasis = $_POST["NumeroChasis"];
        $NumeroMotor = $_POST["NumeroMotor"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $año_fabricacion = $_POST["año_fabricacion"];
        $kilometraje = $_POST["kilometraje"];
        $estado = $_POST["estado"];
        $alarma = $_POST["alarma"];
        $tipoVehiculo = $_POST["tipoVehiculo"];



        if (!$this->GerenteModel->getValidarVehiculo($patente)) {
            $this->GerenteModel->registrarVehiculo($patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo);
            header("location: ../gerente?vehiculoRegistrado");
        } else {

            header("location: ../gerente?vehiculoNoRegistrado");
        }
    }

    public function irModificarVehiculo(){
        $id = $_POST["idVehiculo"];
        $patente = $_POST["patente"];
        $tipoVehiculo = $_POST["tipoVehiculo"];

        $data["vehiculo"] = $this->GerenteModel->getVehiculosPorId($id);
        if ($data != null) {
            echo $this->render->render("view/partial/modificarVehiculoView.mustache", $data);

        }else{
            header("location:/gerente?noRedirecciono");
        }
    }

    public function modificarVehiculo(){
        $patente = $_POST["patente"];
        $NumeroChasis = $_POST["NumeroChasis"];
        $NumeroMotor = $_POST["NumeroMotor"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $año_fabricacion = $_POST["año_fabricacion"];
        $kilometraje = $_POST["kilometraje"];
        $estado = $_POST["estado"];
        $alarma = $_POST["alarma"];
        $tipoVehiculo = $_POST["tipoVehiculo"];

        if(isset( $_POST["idVehiculo"]) && isset($_POST["patente"])){
            $id = $_POST["idVehiculo"];

            if ($this->GerenteModel->getVehiculosPorId($id)) {
                $this->GerenteModel->modificarVehiculo($id, $patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo);
                header("location:/gerente?vehiculoModificado");
            }else{
                header("location:/gerente?errorAlmodificar");
            }

        }else{
            header("location:/gerente?errorAlmodificar");
        }

    }

    public function BorrarVehiculo(){
        $idVehiculo = $_POST["idVehiculo"];


        if ($this->GerenteModel->getVehiculosPorId($idVehiculo)) {
            $this->GerenteModel->borrarVehiculo($idVehiculo);
            header("location: ../gerente?vehiculoBorrado");
        }else{

            header("location: ../gerente?vehiculoNoBorrado");
        }
    }

    }
