<?php

class ChoferController
{
    private $ChoferModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($ChoferModel, $render, $usuarioModel, $verificarRolModel)
    {
        $this->ChoferModel = $ChoferModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
    }


    public function execute()

    {

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            $idChofer = $this->usuarioModel->getIdUsuario($sesion);

            $IdViaje = $this->ChoferModel->getViajeDelChofer($idChofer);

            $datas = array("viajeEnCurso" => $this->ChoferModel->getViajeEnCurso($idChofer),
                "historialPuntoDeControl" => $this->ChoferModel->getProforma($IdViaje),
                "viajeEmpezado" => $this->ChoferModel->getViajeEmpezado($idChofer),
                "sumaTotalPuntoDeControl" => $this->ChoferModel->getSumaTotalProforma($IdViaje),
                "totalDeTotales" => $this->ChoferModel->getSumaTotalTotalesProforma($IdViaje), "url" => "../chofer");

            $datas["rol"] = "Chofer";
            $datas["iconoPrimerBoton"] = 'M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z';
            $datas["primerBoton"] = "Control de viajes";
            $datas["rutaPrimerBoton"] = "../chofer";
            $sesion = $_SESSION["Usuario"];
            $id = $this->usuarioModel->getIdUsuario($sesion);
            $this->usuarioModel->getNombreUsuario($id);
            $datas["nombre"] = $this->usuarioModel->getNombreUsuario($id);
            $datas["apellido"] = $this->usuarioModel->getApellidoUsuario($id);

            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esChofer($tipoUsuario)) {
                echo $this->render->render("view/choferView.mustache", $datas);
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

    public function empezarViaje()
    {
        /* agreegar isset*/
        $latitud_inicio = $_POST["latitud_inicio"];
        $longitud_inicio = $_POST["longitud_inicio"];

        if ($latitud_inicio == null) {
            $latitud_inicio = 0;
        }

        if ($longitud_inicio == null) {
            $longitud_inicio = 0;
        }

        $fechaInicioReal = date('y-m-d');
        $horita = new DateTime();
        $horaInicioReal = $horita->format('H:i:s');
        $id_viaje = $_POST["id_viaje"];


        $this->ChoferModel->getEmpezarViaje($id_viaje, $latitud_inicio, $longitud_inicio, $fechaInicioReal, $horaInicioReal);
        $this->ChoferModel->vehiculoEnViaje($id_viaje);
        $this->ChoferModel->cargaProforma($id_viaje);
        header("location: /chofer");

    }


    public function recargaCombustible()
    {
        $combustible_real = $_POST["combustible_real"];
        $precioCombustible_real = $_POST["precioCombustible_real"];
        $id_viaje = $_POST["id_viaje"];
        $latitudCombustible = $_POST["latitudCombustible"];
        $longitudCombustible = $_POST["longitudCombustible"];
        $direccionActual = $_POST["direccionActual"];
        $horita = date('Y-m-d H:i:s');
        $precioViaticos_actual = 0;
        $precioPeajes_actual = 0;
        $precioExtras_actual = 0;
        $km_actuales = $_POST["km_actuales"];
        $desviacion_actual = isset($_POST["desviacion_actual"]) ? $_POST["desviacion_actual"] : 0;


        $this->ChoferModel->recargaCombustible($combustible_real, $precioCombustible_real, $precioViaticos_actual, $precioPeajes_actual, $precioExtras_actual, $id_viaje, $horita,
            $latitudCombustible, $longitudCombustible, $direccionActual, $km_actuales, $desviacion_actual
        );


        header("location: /chofer?funciona");
    }

    public function gastoPeajeYExtra()
    {
        $precioPeajes_actual = $_POST["precioPeajes_actual"];
        $precioExtras_actual = $_POST["precioExtras_actual"];
        $precioViaticos_actual = $_POST["precioViaticos_actual"];
        $combustible_real = 0;
        $precioCombustible_real = 0;
        $id_viaje = $_POST["id_viaje"];
        $latitudGastos = $_POST["latitudGastos"];
        $longitudGastos = $_POST["longitudGastos"];
        $direccionActual = $_POST["direccionActual"];
        $horita = date('Y-m-d H:i:s');

        if ($precioPeajes_actual == null) {
            $precioPeajes_actual = 0;
        }

        if ($precioExtras_actual == null) {
            $precioExtras_actual = 0;
        }

        if ($precioViaticos_actual == null) {
            $precioViaticos_actual = 0;
        }


        $this->ChoferModel->gastoPeajeYExtra($combustible_real, $precioCombustible_real, $precioViaticos_actual,
            $precioPeajes_actual, $precioExtras_actual, $id_viaje, $horita,
            $latitudGastos, $longitudGastos, $direccionActual
        );


        header("location: /chofer?funciona");
    }

    public function informarPosicion()
    {

        $combustible_real = 0;
        $precioCombustible_real = 0;
        $precioPeajes_actual = 0;
        $precioExtras_actual = 0;
        $precioViaticos_actual = 0;
        $latitud_actual = $_POST["latitud_actual"];
        $longitud_actual = $_POST["longitud_actual"];
        $id_viaje = $_POST["id_viaje"];
        $direccionActual = $_POST["direccionActual"];
        $horita = date('Y-m-d H:i:s');


        $this->ChoferModel->informarPosicion($combustible_real, $precioCombustible_real, $precioViaticos_actual,
            $precioPeajes_actual, $precioExtras_actual, $id_viaje, $horita,
            $latitud_actual, $longitud_actual, $direccionActual
        );


        header("location: /chofer");


    }

    public function finalizarViaje()

    {

        $totalKilometrosRecorridos = $_POST["totalKmRecorridos"];

        $totalDesviaciones = $_POST["totalDesviaciones"];

        $cantidadDeCombustible = $_POST["cantidadDeCombustible"];

        $promedioPrecioCombustible = $_POST["promedioPrecioCombustible"];

        $totalPeaje = $_POST["totalPeaje"];

        $totalViaticos = $_POST["totalViaticos"];

        $totalExtras = $_POST["totalExtras"];

        $totalCombustible = $_POST["totalCombustible"];

        $id_viaje = $_POST["id_viaje"];

        $totalDeTotales = $_POST["totalDeTotales"];

        $viaje_enCurso = 0;

        $viaje_eliminado = 1;

        $viaje_asignado = 0;

        $fechaFinReal = date('y-m-d');
        $horita = new DateTime();
        $horaFinReal = $horita->format('H:i:s');
        $fechaInicioReal = $this->ChoferModel->getFechaInicioReal($id_viaje);

        $dias = (strtotime($fechaInicioReal)-strtotime($fechaFinReal))/86400;
        $dias = abs($dias); $dias = floor($dias);

        $this->ChoferModel->finalizarViaje($cantidadDeCombustible, $promedioPrecioCombustible, $totalPeaje,

            $totalViaticos, $totalExtras, $totalCombustible,

            $id_viaje, $totalDeTotales, $viaje_enCurso, $viaje_eliminado, $totalKilometrosRecorridos, $totalDesviaciones, $fechaFinReal, $horaFinReal, $dias);


        $this->ChoferModel->finalizarProforma($id_viaje);

        $this->ChoferModel->liberarVehiculo($id_viaje, $viaje_asignado);

        $this->ChoferModel->liberarChofer($id_viaje, $viaje_asignado);


        header("location: /chofer");

    }

}