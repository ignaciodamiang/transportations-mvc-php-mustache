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
                WHERE id_usuario = '$idChofer' and viaje_enCurso = '0' ";
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

    public function recargaCombustible($combustible_real,$precioCombustible_real,$id_viaje,$ahora,$latitudCombustible,$longitudCombustible,$direccionActual){

        $sql= "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`, `id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
        VALUES ( '$combustible_real', '$precioCombustible_real', '$id_viaje','$ahora','$latitudCombustible','$longitudCombustible','$direccionActual')";
        $this->database->execute($sql);
    }

    public function gastoPeajeYExtra($precioPeajes_actual,$precioExtras_actual,$precioViaticos_actual,$id_viaje,$ahora,$latitudGastos,$longitudGastos,$direccionActual){

            $sql= "INSERT INTO `ProformaChofer` (`precioPeajes_actual`, `precioExtras_actual`,`precioViaticos_actual`, `id_viaje`,`fechaHoraPuntoControl`,`latitud_actual`, `longitud_actual`,`direccion_actual`)   
            VALUES ( '$precioPeajes_actual', '$precioExtras_actual','$precioViaticos_actual', '$id_viaje','$ahora','$latitudGastos','$longitudGastos','$direccionActual')";
            $this->database->execute($sql);

    }

    public function informarPosicion($id_viaje,$latitud_actual, $longitud_actual,$ahora,$direccionActual){
        $sql= "INSERT INTO `ProformaChofer` (`latitud_actual`, `longitud_actual`, `id_viaje`,`fechaHoraPuntoControl`,`direccion_actual`)   
        VALUES ( '$latitud_actual', '$longitud_actual', '$id_viaje','$ahora','$direccionActual')";
        $this->database->execute($sql);
    }

    public function getProforma($id_viaje){
        $sql="SELECT * from ProformaChofer
                where id_viaje = '$id_viaje' and fechaHoraPuntoControl is not null 
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

    public function finalizarViaje($cantidadDeCombustible,$promedioPrecioCombustible, $totalPeaje,$totalViaticos,$totalExtras,$totalCombustible,$id_viaje){
        $sql="UPDATE `transporteslamatanza`.`Viaje`
                SET `precioExtras_real` = '$totalExtras', 
                    `precioViaticos_Real` = '$totalViaticos', 
                    `precioPeajes_Real` = ' $totalPeaje', 
                    `combustible_real` = '$cantidadDeCombustible', 
                    `precioCombustible_real` = '$promedioPrecioCombustible', 
                    `costoTotalCombustible_real` = '$totalCombustible' 
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

    public function liberarChofer($idViaje){
       $idChofer=$this->obtenerIdUsuarioPorViaje($idViaje);

        $sql="UPDATE `transporteslamatanza`.`usuario` 
                SET `viaje_asignado` = '0' 
                WHERE (`id` = '$idChofer')"; 
        $this->database->execute($sql);
    }


    public function liberarVehiculo($idViaje){
        $idVehiculo=$this->obtenerIdVehiculoPorViaje($idViaje);

        $sql="UPDATE `transporteslamatanza`.`Vehiculo`
        SET `viaje_asignado` = 0, 
        WHERE (`id` = '1')"; 
        $this->database->execute($sql);
    }


}