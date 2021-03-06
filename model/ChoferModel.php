<?php

class ChoferModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getViajeEnCurso($idChofer){
        $sql = "SELECT * FROM Viaje INNER JOIN TipoVehiculo ON Viaje.id_vehiculo = TipoVehiculo.id
                WHERE id_usuario = '$idChofer' and viaje_enCurso = '0' and viaje_eliminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getViajeEmpezado($idChofer){
        $sql = "SELECT * FROM Viaje
                WHERE id_usuario = '$idChofer' and viaje_enCurso = '1' ";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getEmpezarViaje($id_viaje,$latitud_inicio, $longitud_inicio,$fechaInicioReal,$horaInicioReal){
        $sql="UPDATE Viaje 
                SET latitud_inicio = '$latitud_inicio', longitud_inicio = '$longitud_inicio' ,
                fecha_inicioReal='$fechaInicioReal', hora_inicio='$horaInicioReal',
                viaje_enCurso= '1'
                WHERE (`id` = '$id_viaje')";
        $this->database->execute($sql);

    }

    public function recargaCombustible($combustible_real,$precioCombustible_real,$precioViaticos_actual,$precioPeajes_actual,$precioExtras_actual,$id_viaje,$ahora,$latitudCombustible,$longitudCombustible,$direccionActual){

        $sql= "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
        VALUES ( '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
        $this->database->execute($sql);
    }

    public function gastoPeajeYExtra($combustible_real,$precioCombustible_real,$precioViaticos_actual,$precioPeajes_actual,$precioExtras_actual,$id_viaje,$ahora,$latitudCombustible,$longitudCombustible,$direccionActual){

            $sql= "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
            VALUES (  '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
            $this->database->execute($sql);

    }

    public function informarPosicion($combustible_real,$precioCombustible_real,$precioViaticos_actual,$precioPeajes_actual,$precioExtras_actual,$id_viaje,$ahora,$latitudCombustible,$longitudCombustible,$direccionActual){
        $sql= "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`,`precioViaticos_actual`,`precioPeajes_actual`,`precioExtras_actual`,`id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
        VALUES ( '$combustible_real', '$precioCombustible_real','$precioViaticos_actual','$precioPeajes_actual','$precioExtras_actual', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
        $this->database->execute($sql);
    }

    public function getProforma($id_viaje){
        $sql="SELECT * from ProformaChofer
                where id_viaje = '$id_viaje' and  fechaHoraPuntoControl is not null 
                order by fechaHoraPuntoControl desc";
         return $this->database->query($sql);
       
    }

    public function cargaProforma($id_viaje){
        $sql="INSERT into ProformaChofer( id_viaje)
        values($id_viaje)";
        $this->database->execute($sql);

    }

    public function getViajeDelChofer($idChofer){
        $sql = "SELECT id FROM Viaje
                WHERE id_usuario = '$idChofer'";
        $consulta["id_viaje"] = $this->database->query($sql);
        return $consulta["id_viaje"]["0"]["id"];
    }

    public function getSumaTotalProforma($idViaje){
        $sql = "SELECT
                id_viaje,
                sum((combustible_actual*precioCombustible_actual)) as totalCombustible,
                sum(precioPeajes_actual )as 'TotalPeaje',
                sum(precioViaticos_actual)as 'TotalViaticos',
                sum(precioExtras_actual)as 'TotalExtras',
                sum(combustible_actual) as 'cantidadDeCombustible',
                avg(precioCombustible_actual) as 'promedioPrecioCombustible'
                from ProformaChofer
                where id_viaje='$idViaje'";
                return $this->database->query($sql);
    }

    public function finalizarViaje($cantidadDeCombustible,$promedioPrecioCombustible, $totalPeaje,
                                    $totalViaticos,$totalExtras,$totalCombustible,
                                    $id_viaje,$totalDeTotales,$viaje_enCurso,$viaje_eliminado){

        $sql="UPDATE `transporteslamatanza`.`Viaje`
                SET `precioExtras_real` = '$totalExtras', 
                    `precioViaticos_Real` = '$totalViaticos', 
                    `precioPeajes_Real` = ' $totalPeaje', 
                    `combustible_real` = '$cantidadDeCombustible', 
                    `precioCombustible_real` = '$promedioPrecioCombustible', 
                    `costoTotalCombustible_real` = '$totalCombustible' ,
                    `precioTotal_real`='$totalDeTotales',
                    `viaje_enCurso`= '$viaje_enCurso',
                    `viaje_eliminado`='$viaje_eliminado'
                WHERE (`id` = $id_viaje)";

         $this->database->execute($sql);
    }

    public function getSumaTotalTotalesProforma($idViaje){
        $array["totales"]=$this->getSumaTotalProforma($idViaje);

        
        $totalCombustible = floatval($array["totales"]["0"]["totalCombustible"]);
        $totalPeaje = floatval($array["totales"]["0"]["TotalPeaje"]);
        $totalViaticos = floatval($array["totales"]["0"]["TotalViaticos"]);
        $totalExtras = floatval($array["totales"]["0"]["TotalExtras"]);
        $cantidadDeCombustible = floatval($array["totales"]["0"]["cantidadDeCombustible"]);
        $promedioPrecioCombustible = floatval($array["totales"]["0"]["promedioPrecioCombustible"]);

        $totalDeTotales=$totalCombustible+$totalPeaje+$totalViaticos+$totalExtras+$cantidadDeCombustible+$promedioPrecioCombustible;
    
        return $totalDeTotales;
    }

    public function obtenerIdUsuarioPorViaje($idViaje){
        $sql="SELECT id_usuario
            from Viaje
            where  id = '$idViaje'";

        $viaje["idUsuario"] = $this->database->query($sql);
        return $viaje["idUsuario"]["0"]["id_usuario"];
    }
    
    public function obtenerIdVehiculoPorViaje($idViaje){
        $sql="SELECT id_vehiculo
        from Viaje
        where  id = '$idViaje'";

        $vehiculo["idVehiculo"] = $this->database->query($sql);
        return $vehiculo["idVehiculo"]["0"]["id_vehiculo"];
    }

    public function liberarChofer($idViaje,$viaje_asignado){
       $idChofer=$this->obtenerIdUsuarioPorViaje($idViaje);

        $sql="UPDATE `transporteslamatanza`.`usuario` 
                SET `viaje_asignado` = '$viaje_asignado' 
                WHERE (`id` = '$idChofer')"; 
        $this->database->execute($sql);
    }


    public function liberarVehiculo($idViaje,$viaje_asignado){
        $idVehiculo=$this->obtenerIdVehiculoPorViaje($idViaje);

        $sql="UPDATE `transporteslamatanza`.`Vehiculo`
        SET `viaje_asignado` = '$viaje_asignado', 
        WHERE (`id` = '$idVehiculo')"; 
        $this->database->execute($sql);
    }

    public function finalizarProforma($idViaje){
        $sql="UPDATE `transporteslamatanza`.`ProformaChofer` 
                SET   `proformar_eliminada` == '1',
                WHERE (`id_viaje` = '$idViaje')";

                return $this->database->execute($sql);
    }
}