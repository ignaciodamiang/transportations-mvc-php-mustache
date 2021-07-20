<?php

class ChoferModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getViajeEnCurso($idChofer)
    {
        $sql = "SELECT * FROM Viaje INNER JOIN TipoVehiculo ON Viaje.id_vehiculo = TipoVehiculo.id
                WHERE id_usuario = '$idChofer' and viaje_enCurso = '0' and viaje_eliminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getViajeEmpezado($idChofer)
    {
        $sql = "SELECT * FROM Viaje
                WHERE id_usuario = '$idChofer' and viaje_enCurso = '1' ";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getEmpezarViaje($id_viaje, $latitud_inicio, $longitud_inicio, $fechaInicioReal, $horaInicioReal)
    {
        $sql = "UPDATE Viaje 
                SET latitud_inicio = '$latitud_inicio', longitud_inicio = '$longitud_inicio' ,
                fecha_inicioReal='$fechaInicioReal', hora_inicio='$horaInicioReal',
                viaje_enCurso= '1'
                WHERE (`id` = '$id_viaje')";
        $this->database->execute($sql);

    }

    public function recargaCombustible($combustible_real, $precioCombustible_real, $precioViaticos_actual, $precioPeajes_actual, $precioExtras_actual, $id_viaje, $ahora, $latitudCombustible, $longitudCombustible, $direccionActual, $km_actuales, $desviacion_actual)
    {

        $sql = "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`, `km_actuales`, `desviacion_actual`)   
        VALUES ( '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual', '$km_actuales', '$desviacion_actual')";
        $this->database->execute($sql);
    }

    public function gastoPeajeYExtra($combustible_real, $precioCombustible_real, $precioViaticos_actual, $precioPeajes_actual, $precioExtras_actual, $id_viaje, $ahora, $latitudCombustible, $longitudCombustible, $direccionActual)
    {

        $sql = "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
            VALUES (  '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
        $this->database->execute($sql);

    }

    public function informarPosicion($combustible_real, $precioCombustible_real, $precioViaticos_actual, $precioPeajes_actual, $precioExtras_actual, $id_viaje, $ahora, $latitudCombustible, $longitudCombustible, $direccionActual)
    {
        $sql = "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
        VALUES ( '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
        $this->database->execute($sql);
    }

    public function getProforma($id_viaje)
    {
        $sql = "SELECT * 
                from ProformaChofer inner join Viaje
                where ProformaChofer.id_viaje = '$id_viaje' and  Viaje.viaje_enCurso = '1' and fechaHoraPuntoControl is not null 
                order by fechaHoraPuntoControl desc";
        return $this->database->query($sql);

    }

    public function cargaProforma($id_viaje)
    {
        $sql = "INSERT into ProformaChofer( id_viaje)
        values($id_viaje)";
        $this->database->execute($sql);

    }

    public function getViajeDelChofer($idChofer)
    {
        $sql = "SELECT id FROM Viaje
                WHERE id_usuario = '$idChofer'
                order by id desc";
        $consulta["id_viaje"] = $this->database->query($sql);
        return $consulta["id_viaje"]["0"]["id"];
    }

    public function getSumaTotalProforma($idViaje)
    {
        $sql = "SELECT id_viaje,viaje_enCurso,
                sum((combustible_actual*precioCombustible_actual)) as totalCombustible,
                sum(precioPeajes_actual )as 'TotalPeaje',
                sum(precioViaticos_actual)as 'TotalViaticos',
                sum(precioExtras_actual)as 'TotalExtras',
                sum(combustible_actual) as 'cantidadDeCombustible',
                sum(km_actuales) as 'KilometrosRecorridos',
                sum(desviacion_actual) as 'Desviaciones',
                avg(precioCombustible_actual) as 'promedioPrecioCombustible'
                from ProformaChofer inner join Viaje
                where id_viaje='$idViaje' and viaje_enCurso = '1'";
        return $this->database->query($sql);
    }

    public function getFechaInicioReal($idViaje)
    {

        $sql = "SELECT fecha_inicioReal
            from Viaje
            where  id = '$idViaje'";

        $viaje["fecha_inicioReal"] = $this->database->query($sql);
        return $viaje["fecha_inicioReal"]["0"]["fecha_inicioReal"];
    }

    public function obtenerIdVehiculoPorViaje($idViaje)
    {
        $sql = "SELECT id_vehiculo
        from Viaje
        where  id = '$idViaje'";

        $vehiculo["idVehiculo"] = $this->database->query($sql);
        return $vehiculo["idVehiculo"]["0"]["id_vehiculo"];
    }

    public function finalizarViaje($cantidadDeCombustible, $promedioPrecioCombustible, $totalPeaje,
                                   $totalViaticos, $totalExtras, $totalCombustible,
                                   $id_viaje, $totalDeTotales, $viaje_enCurso, $viaje_eliminado, $totalKilometrosRecorridos, $totalDesviaciones, $fechaFinReal, $horaFinReal, $diasDiferencia)
    {

        $sql = "UPDATE `transporteslamatanza`.`Viaje`
                SET `precioExtras_real` = '$totalExtras', 
                    `precioViaticos_Real` = '$totalViaticos', 
                    `precioPeajes_Real` = ' $totalPeaje', 
                    `combustible_real` = '$cantidadDeCombustible', 
                    `precioCombustible_real` = '$promedioPrecioCombustible', 
                    `costoTotalCombustible_real` = '$totalCombustible' ,
                    `precioTotal_real`='$totalDeTotales',
                    `viaje_enCurso`= '$viaje_enCurso',
                    `viaje_eliminado`='$viaje_eliminado',
                    `km_reales`= '$totalKilometrosRecorridos',
                    `desviacion` = '$totalDesviaciones',
                    `viaje_terminado` = '1',
                    `fecha_finReal` = '$fechaFinReal',
                    `hora_fin` = '$horaFinReal',
                    `tiempo_real` = '$diasDiferencia'
                    
                WHERE (`id` = '$id_viaje')";

        $this->database->execute($sql);
        $this->estadisticasVehiculos($this->obtenerIdVehiculoPorViaje($id_viaje));
    }

    public function getSumaTotalTotalesProforma($idViaje)
    {
        $array["totales"] = $this->getSumaTotalProforma($idViaje);


        $totalCombustible = floatval($array["totales"]["0"]["totalCombustible"]);
        $totalPeaje = floatval($array["totales"]["0"]["TotalPeaje"]);
        $totalViaticos = floatval($array["totales"]["0"]["TotalViaticos"]);
        $totalExtras = floatval($array["totales"]["0"]["TotalExtras"]);
        $cantidadDeCombustible = floatval($array["totales"]["0"]["cantidadDeCombustible"]);
        $promedioPrecioCombustible = floatval($array["totales"]["0"]["promedioPrecioCombustible"]);

        $totalDeTotales = $totalCombustible + $totalPeaje + $totalViaticos + $totalExtras + $cantidadDeCombustible + $promedioPrecioCombustible;

        return $totalDeTotales;
    }

    public function obtenerIdUsuarioPorViaje($idViaje)
    {
        $sql = "SELECT id_usuario
            from Viaje
            where  id = '$idViaje'";

        $viaje["idUsuario"] = $this->database->query($sql);
        return $viaje["idUsuario"]["0"]["id_usuario"];
    }

    public function liberarChofer($idViaje, $viaje_asignado)
    {
        $idChofer = $this->obtenerIdUsuarioPorViaje($idViaje);

        $sql = "UPDATE `transporteslamatanza`.`usuario` 
                SET `viaje_asignado` = '$viaje_asignado' 
                WHERE (`id` = '$idChofer')";
        $this->database->execute($sql);
    }


    public function vehiculoEnViaje($idViaje)
    {
        $idVehiculo = $this->obtenerIdVehiculoPorViaje($idViaje);

        $sql = "UPDATE `transporteslamatanza`.`Vehiculo`
        SET `vehiculo_EnViaje` = '1'
        WHERE (`id` = '$idVehiculo')";
        $this->database->execute($sql);
    }

    public function liberarVehiculo($idViaje, $viaje_asignado)
    {
        $idVehiculo = $this->obtenerIdVehiculoPorViaje($idViaje);

        $sql = "UPDATE `transporteslamatanza`.`Vehiculo`
        SET `viaje_asignado` = '$viaje_asignado',
        `vehiculo_EnViaje` = '0' 
        WHERE (`id` = '$idVehiculo')";
        $this->database->execute($sql);
    }

    public function finalizarProforma($idViaje)
    {
        $sql = "UPDATE `transporteslamatanza`.`ProformaChofer` 
                SET   `proformar_eliminada` == '1'
                WHERE (`id_viaje` = '$idViaje')";

        return $this->database->execute($sql);
    }

    public function combustibleConsumido($idVehiculo)
    {

        $sql = "SELECT combustible_real
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["combustible_real"] = $this->database->query($sql);
        return $vehiculo["combustible_real"]["0"]["combustible_real"];

    }

    public function precioCombustibleConsumido($idVehiculo)
    {
        $sql = "SELECT precioCombustible_real
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["precioCombustible_real"] = $this->database->query($sql);
        return $vehiculo["precioCombustible_real"]["0"]["precioCombustible_real"];

    }

    public function kilometrosVehiculoRecorridos($idVehiculo)
    {

        $sql = "SELECT km_reales
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["km_reales"] = $this->database->query($sql);
        return $vehiculo["km_reales"]["0"]["km_reales"];

    }

    public function costoDeMantenimiento($idVehiculo)
    {

        $sql = "SELECT 
                sum(costo) as 'CostoTotalMantenimiento'
                from Services where id_vehiculo ='$idVehiculo'";
        $consulta["costoMantenimiento"] = $this->database->query($sql);
        if (isset($consulta["costoMantenimiento"]["0"]["costoMantenimiento"]) && !empty($consulta["costoMantenimiento"]["0"]["costoMantenimiento"]) && $consulta["costoMantenimiento"]["0"]["costoMantenimiento"] != null) {
            return $consulta["costoMantenimiento"]["0"]["costoMantenimiento"];
        } else {
            return 0;

        }

    }

    public function costoPorKilometroRecorrido($idVehiculo)
    {

        $kilometrosRecorridos = $this->kilometrosVehiculoRecorridos($idVehiculo);
        $combustibleConsumido = $this->combustibleConsumido($idVehiculo);
        $precioCombustibleConsumido = $this->precioCombustibleConsumido($idVehiculo);

        $costoPorKilometroRecorrido = $kilometrosRecorridos / ($combustibleConsumido * $precioCombustibleConsumido);

        return $costoPorKilometroRecorrido;

    }

    public function desvios($idVehiculo)
    {
        $sql = "SELECT desviacion
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["desviacion"] = $this->database->query($sql);
        return $vehiculo["desviacion"]["0"]["desviacion"];

    }

    public function tiempoRealDeViaje($idVehiculo)
    {
        $sql = "SELECT tiempo_real
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["tiempo_real"] = $this->database->query($sql);
        return $vehiculo["tiempo_real"]["0"]["tiempo_real"];

    }


    public function tiempoEstimadoViaje($idVehiculo)
    {

        $sql = "SELECT tiempo_estimado
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["tiempo_estimado"] = $this->database->query($sql);
        return $vehiculo["tiempo_estimado"]["0"]["tiempo_estimado"];

    }

    public function estadisticasVehiculos($idVehiculo)
    {

        $tiempoFueraDeServicio = 0;
        $kilometrosVehiculoRecorridos = $this->kilometrosVehiculoRecorridos($idVehiculo);
        $costoMantenimiento = $this->costoDeMantenimiento($idVehiculo);
        $costoPorKilometroRecorrido = $this->costoPorKilometroRecorrido($idVehiculo);
        $desvios = $this->desvios($idVehiculo);
        $tiempoEstimadoViaje = $this->tiempoEstimadoViaje($idVehiculo);
        $tiempoRealDeViaje = $this->tiempoRealDeViaje($idVehiculo);

        $estadisticas["tiempoFueraDeServicio"] = $tiempoFueraDeServicio;
        $estadisticas["kilometrosVehiculoRecorridos"] = $kilometrosVehiculoRecorridos;
        $estadisticas["costoMantenimiento"] = $costoMantenimiento;
        $estadisticas["costoPorKilometroRecorrido"] = $costoPorKilometroRecorrido;
        $estadisticas["desvios"] = $desvios;
        $estadisticas["tiempoEstimadoViaje"] = $tiempoEstimadoViaje;
        $estadisticas["tiempoRealDeViaje"] = $tiempoRealDeViaje;


        $sql3 = "SELECT * FROM reporteVehiculo
                WHERE id_vehiculo= '$idVehiculo' ";
        $consultaSiExisteReporte = $this->database->query($sql3);


        if (isset($consultaSiExisteReporte) && !empty($consultaSiExisteReporte) && $consultaSiExisteReporte != null) {

            $sql4 = "UPDATE `transporteslamatanza`.`reporteVehiculo` 
                SET `kilometrosVehiculoRecorridos` = '$kilometrosVehiculoRecorridos',
                `costoMantenimiento` = '$costoMantenimiento',
                `costoPorKilometroRecorrido` = '$costoPorKilometroRecorrido',
                `desvios` = '$desvios',
                `tiempoEstimadoViaje` = '$tiempoEstimadoViaje',
                `tiempoRealDeViaje` = '$tiempoRealDeViaje',
                WHERE (`id_vehiculo` = '$idVehiculo')";

            $this->database->execute($sql4);
        } else {

            $sql = "INSERT INTO reporteVehiculo (tiempoFueraDeServicio, kilometrosVehiculoRecorridos, costoMantenimiento, costoPorKilometroRecorrido, desvios, tiempoEstimadoViaje, tiempoRealDeViaje, id_vehiculo)
VALUES( '$tiempoFueraDeServicio',
        '$kilometrosVehiculoRecorridos',
        '$costoMantenimiento',        
        '$costoPorKilometroRecorrido',       
        '$desvios',       
        '$tiempoEstimadoViaje',
        '$tiempoRealDeViaje',
        '$idVehiculo'
        )";

            return $this->database->execute($sql);

        }


    }
    
}