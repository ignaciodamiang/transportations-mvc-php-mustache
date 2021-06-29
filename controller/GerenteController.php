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

    public function registrarViaje()
    {

        $CiudadOrigen = $_POST["ciudad_origen"];
        $CiudadDestino = $_POST["ciudad_destino"];
        $FechaInicio = $_POST["fecha_inicio"];
        $HoraInicio = $_POST["hora_inicio"];
        $FechaFin = $_POST["fecha_fin"];
        $HoraFin = $_POST["hora_fin"];
        $TiempoEstimado = $_POST["tiempo_estimado"];
        $TiempoReal = $_POST["tiempo_real"];
        $TipoCarga = $_POST["tipo_carga"];
        $KmPrevisto = $_POST["km_previsto"];
        $KmReales = $_POST["km_reales"];
        $Desviacion = $_POST["desviacion"];
        $PosicionGps = $_POST["posicion_gps"];
        $CombustibleEstimado = $_POST["combustible_estimado"];
        $CombustibleReal = $_POST["combustible_real"];
        $Vehiculo = $_POST["id_vehiculo"];
        $Chofer = $_POST["id_usuario"];

        $this->GerenteModel->registrarViaje($CiudadOrigen, $CiudadDestino, $FechaInicio, $HoraInicio, $FechaFin, $HoraFin, $TiempoEstimado, $TiempoReal, $TipoCarga, $KmPrevisto, $KmReales, $Desviacion, $PosicionGps, $CombustibleEstimado, $CombustibleReal, $Vehiculo, $Chofer);

        header("location: ../gerente");

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
