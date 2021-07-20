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
        $datas = array("todosLosVehiculos" => $this->GerenteModel->getVehiculos(), "vehiculosSinUso" => $this->GerenteModel->getVehiculosSinUso(), "todosLosChoferesSinViajes" => $this->GerenteModel->getListaDeChoferesSinViajes(), "todosLosChoferes" => $this->GerenteModel->getListaDeChoferes(), "todosLosViajes" => $this->GerenteModel->getViajes(), "urlRegistrarViaje" => $urlRegistrarViaje, "url" => "../gerente");
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
        $datas["reportes"] = $this->GerenteModel->getEstadisticasVehiculos();
        $datas["viajesTerminados"] = $this->GerenteModel->getViajesTerminados();

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

                    if (!$this->GerenteModel->registrarViaje($ciudad_origen,
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
                        $id_usuario)) {

                        $this->GerenteModel->asignarViajeChofer($id_usuario);
                        $this->GerenteModel->asignarViajeVehiculo($id_vehiculo);

                        $this->GerenteModel->registrarCliente($nombre, $apellido);
                        $id_cliente = $this->GerenteModel->getIdCliente($nombre, $apellido);
                        $id_viaje = $this->GerenteModel->getIdViaje($ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_fin, $id_usuario);
                        $this->GerenteModel->generarFactura($CostoTotalEstimado, $id_viaje, $id_cliente);

                        $nombreChofer = $this->usuarioModel->getNombreUsuario($id_usuario);
                        $apellidoChofer = $this->usuarioModel->getApellidoUsuario($id_usuario);


                        header("location:/gerente/pdfViaje?id_usuario=$id_usuario&id_viaje=$id_viaje");

                        $this->GerenteModel->guardarInforme("../gerente/pdfViaje?id_usuario=$id_usuario&id_viaje=$id_viaje", $id_viaje);
                    } else {
                        header("location:/gerente?viajeNoRegistrado");
                    }
                } else {
                    echo $this->render->render("view/proformaCarga.mustache", $datas);

                }


            } else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
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

    public function pdfViaje()
    {
        $id_viaje = $_GET["id_viaje"];
        $id_usuario = $_GET["id_usuario"];
        $viaje["viaje"] = $this->GerenteModel->getViajePorId($id_viaje);
        $ciudad_origen = $viaje["viaje"]["0"]["ciudad_origen"];
        $ciudad_destino = $viaje["viaje"]["0"]["ciudad_destino"];

        $pdf = new FPDF('p', 'mm', 'A4');
        $pdf->AddPage();
        /**/
        $pdf->SetFont('Arial', 'B', 15);
        /*$pdf->Cell(100, 10, $ciudad_destino, 1, 1, 1);*/
        //set font to arial, bold, 14pt
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(130, 5, utf8_decode('Viaje:'), 0, 0);


//Cell(width , height , text , border , end line , [align] )


        $pdf->Cell(59, 5, 'Chofer:', 0, 1);//end of line

//set font to arial, regular, 12pt
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(130, 5, '', 0, 0);
        $pdf->Cell(59, 5, '', 0, 1);//end of line


        $pdf->Cell(130, 5, 'Ciudad origen:   ' . utf8_decode($viaje["viaje"]["0"]["ciudad_origen"]), 0, 0);

        $nombre_chofer = $this->usuarioModel->getNombreUsuario($id_usuario);
        $apellido_chofer = $this->usuarioModel->getApellidoUsuario($id_usuario);
        $dni_cliente = $this->usuarioModel->getDniUsuario($id_usuario);

        $pdf->Cell(25, 5, 'Nombre:', 0, 0);
        $pdf->Cell(34, 5, utf8_decode($nombre_chofer), 0, 1);//end of line

        $pdf->Cell(130, 5, 'Ciudad destino:   ' . utf8_decode($viaje["viaje"]["0"]["ciudad_destino"]), 0, 0);
        $pdf->Cell(25, 5, 'Apellido:', 0, 0);
        $pdf->Cell(34, 5, utf8_decode($apellido_chofer), 0, 1);//end of line

        $pdf->Cell(130, 5, 'Fecha inicio estimada:   ' . utf8_decode($viaje["viaje"]["0"]["fecha_inicio"]), 0, 0);
        $pdf->Cell(25, 5, 'Dni:', 0, 0);
        $pdf->Cell(34, 5, $dni_cliente, 0, 1);//end of line
        $pdf->Cell(130, 5, 'Fecha fin estimada:   ' . utf8_decode($viaje["viaje"]["0"]["fecha_fin"]), 0, 0);
        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line

        $pdf->Cell(130, 5, 'Tipo de carga:   ' . utf8_decode($viaje["viaje"]["0"]["descripcion_carga"]), 0, 0);
        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line

        $pdf->Cell(130, 5, 'Peso de carga:   ' . utf8_decode($viaje["viaje"]["0"]["peso_Neto"]), 0, 0);
        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Temperatura:   ' . utf8_decode($viaje["viaje"]["0"]["temperatura"]), 0, 0);

        if ($viaje["viaje"]["0"]["hazard"] == 1) {

            $hazard = "Si";
        } else {

            $hazard = "No";
        }

        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Hazard:   ' . utf8_decode($hazard), 0, 0);

        if ($viaje["viaje"]["0"]["reefer"] == 1) {

            $reefer = "Si";
        } else {

            $reefer = "No";
        }

        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Reefer:   ' . utf8_decode($reefer), 0, 0);

        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Km previstos:   ' . utf8_decode($viaje["viaje"]["0"]["km_previsto"]), 0, 0);
        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Combustible estimado:   ' . utf8_decode($viaje["viaje"]["0"]["combustible_estimado"]), 0, 0);

        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Precio del combustible estimado:   ' . utf8_decode($viaje["viaje"]["0"]["precioCombustible_estimado"]), 0, 0);

        $pdf->Cell(25, 5, '', 0, 0);
        $pdf->Cell(34, 5, '', 0, 1);//end of line
        $pdf->Cell(130, 5, 'Fee:   %' . utf8_decode($viaje["viaje"]["0"]["fee_estimado"]), 0, 0);

//make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1);//end of line

//billing address
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(100, 10, 'Cliente:', 0, 1);//end of line

        $pdf->SetFont('Arial', '', 12);
        $id_viaje = $viaje["viaje"]["0"]["id"];
        $id_cliente = $this->GerenteModel->getClienteFactura($id_viaje);
        $nombre_cliente = $this->GerenteModel->getNombreClientePorId($id_cliente);
        $apellido_cliente = $this->GerenteModel->getApellidoClientePorId($id_cliente);

//add dummy cell at beginning of each line for indentation
        $pdf->Cell(28, 5, 'Id de cliente:', 0, 0);
        $pdf->Cell(90, 5, $id_cliente, 0, 1);

        $pdf->Cell(20, 5, 'Nombre:', 0, 0);
        $pdf->Cell(90, 5, $nombre_cliente, 0, 1);

        $pdf->Cell(20, 5, 'Apellido:', 0, 0);
        $pdf->Cell(90, 5, $apellido_cliente, 0, 1);


//make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1);//end of line

//invoice contents
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(155, 5, 'Descripcion', 1, 0);
        $pdf->Cell(34, 5, 'Costo', 1, 1);//end of line

        $pdf->SetFont('Arial', '', 12);

//Numbers are right-aligned so we give 'R' after new line parameter

        $pdf->Cell(155, 5, 'Costo total combustible estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["costoTotalCombustible_estimado"], 1, 1, 'R');//end of line

        $pdf->Cell(155, 5, 'Precio de viaticos estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["precioViaticos_estimado"], 1, 1, 'R');//end of line

        $pdf->Cell(155, 5, 'Precio de peajes estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["precioPeajes_estimado"], 1, 1, 'R');//end of line
        $pdf->Cell(155, 5, 'Precio de extras estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["precioExtras_estimado"], 1, 1, 'R');//end of line

        $pdf->Cell(155, 5, 'Precio de hazard estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["precioHazard_estimado"], 1, 1, 'R');//end of line

        $pdf->Cell(155, 5, 'Precio de reefer estimado', 1, 0);

        $pdf->Cell(34, 5, $viaje["viaje"]["0"]["precioReefer_estimado"], 1, 1, 'R');//end of line

//summary


        $pdf->Cell(130, 5, '', 0, 0);
        $pdf->Cell(25, 5, 'Total', 0, 0);
        $pdf->Cell(4, 5, '$', 1, 0);
        $pdf->Cell(30, 5, $viaje["viaje"]["0"]["precioTotal_estimado"], 1, 1, 'R');//end of line

        $pdf->Image("http://localhost/gerente/generarQr?id_usuario=$id_usuario", 138, 40, 50, 50, "png");
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


        $costoTotalCombustible_estimado = $combustible_estimado * $precioCombustible_estimado;
        $precioTotal_estimado = $costoTotalCombustible_estimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado + $precioHazard_estimado + $precioReefer_estimado;
        $AumentoHazardYReefer = $precioTotal_estimado - ($costoTotalCombustible_estimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado);
        $feeCalculo = $AumentoHazardYReefer / ($costoTotalCombustible_estimado + $precioViaticos_estimado + $precioPeajes_estimado + $precioExtras_estimado);
        $fee_estimado = $feeCalculo * 100;

        if (isset($_POST["idViaje"])) {

            if ($this->GerenteModel->getViajePorId($id)) {
                $this->GerenteModel->modificarViaje($id, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_fin, $tiempo_estimado, $descripcion_carga, $km_previsto, $combustible_estimado, $precioViaticos_estimado, $precioPeajes_estimado, $precioExtras_estimado, $precioCombustible_estimado, $costoTotalCombustible_estimado, $peso_Neto, $hazard, $precioHazard_estimado, $reefer, $precioReefer_estimado, $fee_estimado, $temperatura, $precioTotal_estimado, $id_vehiculo, $id_usuario);
                header("location:/gerente?viajeModificado");
            } else {
                header("location:/gerente?errorAlModificarViaje");
            }

        } else {
            header("location:/gerente?errorAlModificarViaje");
        }
    }


    public function borrarViaje()
    {
        $id = $_POST["idViaje"];
        if ($this->GerenteModel->getViajePorId($id)) {
            $this->GerenteModel->borrarViaje($id);
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
                        header("location: ../gerente/vehiculos?vehiculoRegistrado");
                    } else {

                        header("location: ../gerente/registrarVehiculo?vehiculoNoRegistrado");
                    }
                } else {
                    echo $this->render->render("view/agregarVehiculos.mustache", $datas);

                }
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
        }

    }

    public function vehiculos()
    {
        $datas = $this->data();
        $datas["mecanicos"] = $this->GerenteModel->getMecanicos();
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
            header("location: ../gerente/vehiculos?vehiculoBorrado");
        } else {

            header("location: ../gerente?vehiculoNoBorrado");
        }
    }

    public function mandarAServices()
    {


        if (isset($_POST["idVehiculo"], $_POST["idMecanico"])) {
            $idVehiculo = $_POST["idVehiculo"];
            $idMecanico = $_POST["idMecanico"];
            $this->GerenteModel->mandarAServices($idVehiculo, $idMecanico);
            $this->GerenteModel->cambiarEstadoVehiculoAEnReparacion($idVehiculo);

            header("location:../gerente/vehiculos?SeEnvioAServices");
        } else {

            header("location:../gerente/vehiculosElijaVehiculoYMecanico");

        }

    }

}
