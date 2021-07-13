<?php

require_once("fpdf17/fpdf.php");

class GerenteController
{
    private $GerenteModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;


    public function __construct($GerenteModel, $render, $verificarRolModel, $usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
        $this->GerenteModel = $GerenteModel;
        $this->render = $render;

    }


    public function data()
    {
        $urlRegistrarViaje = "gerente/registrarViaje";
        $datas = array("todosLosVehiculos" => $this->GerenteModel->getVehiculos(),"vehiculosSinUso" => $this->GerenteModel->getVehiculosSinUso(), "todosLosChoferes" => $this->GerenteModel->getListaDeChoferes(), "todosLosViajes" => $this->GerenteModel->getViajes(), "urlRegistrarViaje" => $urlRegistrarViaje, "url" => "../gerente");
        $datas["rol"] = "Gerente";
        $datas["iconoPrimerBoton"] = 'M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z';
        $datas["iconoPrimerBoton2"] = 'M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z';
        $datas["primerBoton"] = "Viajes";
        $datas["rutaPrimerBoton"] = "../gerente";
        $datas["iconoSegundoBoton"] = 'M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z';
        $datas["iconoSegundoBoton2"] = 'M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z';
        $datas["segundoBoton"] = "Registrar Viaje";
        $datas["rutaSegundoBoton"] = "../gerente/registrarViaje";
        $datas["iconoTercerBoton"] = 'M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z';
        $datas["tercerBoton"] = "Vehiculos";
        $datas["rutaTercerBoton"] = "../gerente/vehiculos";
        $datas["iconoCuartoBoton"] = 'M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z';
        $datas["iconoCuartoBoton2"] = 'M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z';
        $datas["cuartoBoton"] = "Registrar Vehiculo";
        $datas["rutaCuartoBoton"] = "../gerente/registrarVehiculo";

        $sesion = $_SESSION["Usuario"];
        $id = $this->usuarioModel->getIdUsuario($sesion);
        $this->usuarioModel->getNombreUsuario($id);
        $datas["nombre"] = $this->usuarioModel->getNombreUsuario($id);
        $datas["apellido"] = $this->usuarioModel->getApellidoUsuario($id);

        return $datas;

    }

    public function execute()
    {

        $datas = $this->data();

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esGerente($tipoUsuario)) {

                echo $this->render->render("view/gerenteView.mustache", $datas);

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

    public function registrarViaje()
    {

        $datas = $this->data();

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esGerente($tipoUsuario)) {

            } else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
        }


        if (isset($_POST["ciudad_origen"], $_POST["ciudad_destino"], $_POST["fecha_inicio"], $_POST["fecha_fin"], $_POST["tiempo_estimado"], $_POST["tiempo_estimado"], $_POST["descripcion_carga"], $_POST["km_previsto"], $_POST["combustible_estimado"], $_POST["peso_neto"], $_POST["precioCombustible_estimado"], $_POST["precioViaticos_estimado"], $_POST["precioPeajes_estimado"], $_POST["precioExtras_estimado"], $_POST["hazard"], $_POST["precioHazard_estimado"], $_POST["reefer"], $_POST["precioReefer_estimado"], $_POST["temperatura"], $_POST["id_vehiculo"], $_POST["id_usuario"], $_POST["nombre"], $_POST["apellido"])) {

            $ciudad_origen = $_POST["ciudad_origen"];
            $ciudad_destino = $_POST["ciudad_destino"];
            $fecha_inicio = $_POST["fecha_inicio"];
            $fecha_fin = $_POST["fecha_fin"];
            $tiempo_estimado = $_POST["tiempo_estimado"];
            $tipo_carga = $_POST["descripcion_carga"];
            $km_previsto = $_POST["km_previsto"];
            $combustible_estimado = $_POST["combustible_estimado"];
            $peso_Neto = $_POST["peso_neto"];
            $precioCombustibleEstimado = $_POST["precioCombustible_estimado"];
            $CostoViaticos_estimado = $_POST["precioViaticos_estimado"];
            $CostoPeajesEstimado = $_POST["precioPeajes_estimado"];
            $CostoExtrasEstimado = $_POST["precioExtras_estimado"];
            $hazard = $_POST["hazard"];
            $CostoHazardEstimado = $_POST["precioHazard_estimado"];
            $reefer = $_POST["reefer"];
            $CostoReeferEstimado = $_POST["precioReefer_estimado"];
            $temperatura = $_POST["temperatura"];
            $id_vehiculo = $_POST["id_vehiculo"];
            $id_usuario = $_POST["id_usuario"];


            /*$costoTotalCombustibleEstimado = $km_previsto / ($combustible_estimado * $precioCombustibleEstimado);*/
            $costoTotalCombustibleEstimado = $combustible_estimado * $precioCombustibleEstimado;
            $CostoTotalEstimado = $costoTotalCombustibleEstimado + $CostoViaticos_estimado + $CostoPeajesEstimado + $CostoExtrasEstimado + $CostoHazardEstimado + $CostoReeferEstimado;
            $AumentoHazardYReefer = $CostoTotalEstimado - ($costoTotalCombustibleEstimado + $CostoViaticos_estimado + $CostoPeajesEstimado + $CostoExtrasEstimado);
            $feeCalculo = $AumentoHazardYReefer / ($costoTotalCombustibleEstimado + $CostoViaticos_estimado + $CostoPeajesEstimado + $CostoExtrasEstimado);
            $feeEstimado = $feeCalculo * 100;

            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];

            /*if (!getValidarViaje($fecha_inicio, $fecha_fin, $id_usuario)) {*/
            $this->GerenteModel->registrarViaje($ciudad_origen,
                $ciudad_destino,
                $fecha_inicio,
                $fecha_fin,
                $tiempo_estimado,
                $tipo_carga,
                $km_previsto,
                $combustible_estimado,
                $precioCombustibleEstimado,
                $costoTotalCombustibleEstimado,
                $CostoViaticos_estimado,
                $CostoPeajesEstimado,
                $CostoExtrasEstimado,
                $feeEstimado,
                $peso_Neto,
                $hazard,
                $CostoHazardEstimado,
                $reefer,
                $CostoReeferEstimado,
                $temperatura,
                $CostoTotalEstimado,
                $id_vehiculo,
                $id_usuario
            );
            $this->GerenteModel->asignarViajeChofer($id_usuario);
            $this->GerenteModel->asignarViajeVehiculo($id_vehiculo);

            $this->GerenteModel->registrarCliente($nombre, $apellido);
            $id_cliente = $this->GerenteModel->getIdCliente($nombre, $apellido);
            $id_viaje = $this->GerenteModel->getIdViaje($ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_fin, $id_usuario);
            $this->GerenteModel->generarFactura($CostoTotalEstimado, $id_viaje, $id_cliente);

            $nombreChofer = $this->usuarioModel->getNombreUsuario($id_usuario);
            $apellidoChofer = $this->usuarioModel->getApellidoUsuario($id_usuario);

            header("location:/gerente/crearPdf?id_usuario=$id_usuario&id_viaje=$id_viaje");
            /* } else {
                 header("location:/gerente?viajeNoRegistrado");
             }*/
        } else {
            echo $this->render->render("view/proformaCarga.mustache", $datas);

        }
    }

    public function generarQr()
    {
        $id_usuario = $_GET["id_usuario"];
        include('phpqrcode/qrlib.php');
        $email = $this->usuarioModel->getMailUsuario($id_usuario);
        $contraseña = $this->usuarioModel->getPasswordUsuario($id_usuario);
        $contenido = "http://localhost/login/loguearUsuario?email=$email&&password=$contraseña";
        $imagen = QRcode::png($contenido);
    }

    public function crearPdf()
    {
        $id_viaje = $_GET["id_viaje"];
        $id_usuario = $_GET["id_usuario"];
        $viaje = $this->GerenteModel->getViajePorId($id_viaje);

       /* for ($i = 0; $i < sizeof($viaje); $i++) {
            $elemento = $i . " - " . $viaje[$i] . "<br>";
        }*/

        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image("http://localhost/gerente/generarQr?id_usuario=$id_usuario", 10, 10, 30, 30, "png");
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Output();

    }

    public function irModificarViaje()
    {
        $id = $_POST["idViaje"];
        $viaje = $this->GerenteModel->getViajePorId($id);
        $datas = array("viaje" => $viaje, "todosLosVehiculos" => $this->GerenteModel->getVehiculos(), "todosLosChoferes" => $this->GerenteModel->getListaDeChoferes());

        if ($viaje != null) {
            echo $this->render->render("view/partial/modificarViaje.mustache", $datas);

        } else {
            header("location:/gerente?noRedirecciono");
        }
    }

    public function modificarViaje()
    {
        $id = $_POST["idViaje"];
        $ciudad_origen = $_POST["ciudad_origen"];
        $ciudad_destino = $_POST["ciudad_destino"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $tiempo_estimado = $_POST["tiempo_estimado"];
        $descripcion_carga = $_POST["descripcion_carga"];
        $km_previsto = $_POST["km_previsto"];
        $combustible_estimado = $_POST["combustible_estimado"];
        $precioViaticos_estimado = $_POST["precioViaticos_estimado"];
        $precioPeajes_estimado = $_POST["precioPeajes_estimado"];
        $precioExtras_estimado = $_POST["precioExtras_estimado"];
        $precioCombustible_estimado = $_POST["precioCombustible_estimado"];
        $peso_Neto = $_POST["peso_Neto"];
        $hazard = $_POST["hazard"];
        $precioHazard_estimado = $_POST["precioHazard_estimado"];
        $reefer = $_POST["reefer"];
        $precioReefer_estimado = $_POST["precioReefer_estimado"];
        $temperatura = $_POST["temperatura"];
        $id_vehiculo = $_POST["id_vehiculo"];
        $id_usuario = $_POST["id_usuario"];

        $costoTotalCombustibleEstimado = $combustible_estimado * $precioCombustible_estimado;
        $CostoTotalEstimado = $costoTotalCombustibleEstimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado + $precioHazard_estimado + $precioReefer_estimado;
        $AumentoHazardYReefer = $CostoTotalEstimado - ($costoTotalCombustibleEstimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado);
        $feeCalculo = $AumentoHazardYReefer / ($costoTotalCombustibleEstimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado);
        $fee_estimado = $feeCalculo * 100;

        if (isset($_POST["idViaje"])) {

            if ($this->GerenteModel->getViajePorId($id)) {
                $this->GerenteModel->modificarViaje($id, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_fin, $tiempo_estimado, $descripcion_carga, $km_previsto, $combustible_estimado, $precioViaticos_estimado, $precioPeajes_estimado, $precioExtras_estimado, $precioCombustible_estimado, $costoTotalCombustibleEstimado, $peso_Neto, $hazard, $precioHazard_estimado, $reefer, $precioReefer_estimado, $fee_estimado, $temperatura, $CostoTotalEstimado, $id_vehiculo, $id_usuario);
                header("location:/gerente?viajeModificado");
            } else {
                header("location:/gerente?errorAlModificarViaje");
            }

        } else {
            header("location:/gerente?errorAlModificarViaje");
        }
    }

    public function BorrarViaje()
    {
        $idViaje = $_POST["idViaje"];


        if ($this->GerenteModel->getViajePorId($idViaje)) {
            $this->GerenteModel->borrarViaje($idViaje);
            header("location: ../gerente?viajeBorrado");
        } else {

            header("location: ../gerente?viajeNoBorrado");
        }
    }


    public function registrarVehiculo()
    {

        $datas = $this->data();

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esGerente($tipoUsuario)) {

                echo $this->render->render("view/agregarVehiculos.mustache", $datas);
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
        }


        if (isset($_POST["patente"], $_POST["NumeroChasis"], $_POST["NumeroMotor"], $_POST["marca"], $_POST["modelo"], $_POST["año_fabricacion"], $_POST["kilometraje"], $_POST["estado"], $_POST["alarma"], $_POST["tipoVehiculo"])) {

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
    }

    public function vehiculos()
    {
        $datas = $this->data();

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esGerente($tipoUsuario)) {

                echo $this->render->render("view/vehiculos.mustache", $datas);
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
        }

    }

    public function irModificarVehiculo()
    {
        $id = $_POST["idVehiculo"];
        $patente = $_POST["patente"];
        $tipoVehiculo = $_POST["tipoVehiculo"];

        $data["vehiculo"] = $this->GerenteModel->getVehiculosPorId($id);
        if ($data != null) {
            echo $this->render->render("view/partial/modificarVehiculoView.mustache", $data);

        } else {
            header("location:/gerente?noRedirecciono");
        }
    }

    public function modificarVehiculo()
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

        if (isset($_POST["idVehiculo"]) && isset($_POST["patente"])) {
            $id = $_POST["idVehiculo"];

            if ($this->GerenteModel->getVehiculosPorId($id)) {
                $this->GerenteModel->modificarVehiculo($id, $patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo);
                header("location:/gerente?vehiculoModificado");
            } else {
                header("location:/gerente?errorAlmodificar");
            }

        } else {
            header("location:/gerente?errorAlmodificar");
        }

    }

    public function BorrarVehiculo()
    {
        $idVehiculo = $_POST["idVehiculo"];


        if ($this->GerenteModel->getVehiculosPorId($idVehiculo)) {
            $this->GerenteModel->borrarVehiculo($idVehiculo);
            header("location: ../gerente?vehiculoBorrado");
        } else {

            header("location: ../gerente?vehiculoNoBorrado");
        }
    }

}
