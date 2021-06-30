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

    public function registrarViaje()
    {
        $ciudad_origen = $_POST["ciudad_origen"];
        $ciudad_destino = $_POST["ciudad_destino"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $hora_inicio = $_POST["hora_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $hora_fin = $_POST["hora_fin"];
        $tiempo_estimado = $_POST["tiempo_estimado"];
        $tiempo_real = $_POST["tiempo_real"];
        $tipo_carga = $_POST["tipo_carga"];
        $km_previsto = $_POST["km_previsto"];
        $km_reales = $_POST["km_reales"];
        $desviacion = $_POST["desviacion"];
        $posicion_gps = $_POST["posicion_gps"];
        $combustible_estimado = $_POST["combustible_estimado"];
        $combustible_real = $_POST["combustible_real"];
        $id_vehiculo = $_POST["id_vehiculo"];
        $id_usuario = $_POST["id_usuario"];

                      $this->GerenteModel->registrarViaje($ciudad_origen, $ciudad_destino, $fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $tiempo_estimado, $tiempo_real, $tipo_carga, $km_previsto, $km_reales, $desviacion, $posicion_gps, $combustible_estimado, $combustible_real, $id_vehiculo, $id_usuario);
            header("location: ../gerente?viajeRegistrado");
        }
    }
