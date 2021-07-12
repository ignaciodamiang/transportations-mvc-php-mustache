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

    public function recargaCombustible($combustible_real,$precioCombustible_real,$id_viaje,$ahora){

        $sql= "INSERT INTO `ProformaChofer` (`combustible_actual`, `precioCombustible_actual`, `id_viaje`,`fechaHoraPuntoControl`)   
        VALUES ( '$combustible_real', '$precioCombustible_real', '$id_viaje','$ahora')";
        $this->database->execute($sql);
    }

    public function gastoPeajeYExtra($precioPeajes_actual,$precioExtras_actual,$precioViaticos_actual,$id_viaje,$ahora){

            $sql= "INSERT INTO `ProformaChofer` (`precioPeajes_actual`, `precioExtras_actual`,`precioViaticos_actual`, `id_viaje`,`fechaHoraPuntoControl`)   
            VALUES ( '$precioPeajes_actual', '$precioExtras_actual','$precioViaticos_actual', '$id_viaje','$ahora')";
            $this->database->execute($sql);

    }

    public function informarPosicion($id_viaje,$latitud_actual, $longitud_actual,$ahora){
        $sql= "INSERT INTO `ProformaChofer` (`latitud_actual`, `longitud_actual`, `id_viaje`,`fechaHoraPuntoControl`)   
        VALUES ( '$latitud_actual', '$longitud_actual', '$id_viaje','$ahora')";
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
                WHERE (`id` = '1')";

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

    /*array(1) { [0]=> array(6) { ["totalCombustible"]=> string(5) "10000"
         ["TotalPeaje"]=> string(3) "600"
        ["TotalViaticos"]=> string(3) "100" 
         ["TotalExtras"]=> string(3) "500" 
         ["cantidadDeCombustible"]=> string(3) "100" 
         ["promedioPrecioCombustible"]=> string(3) "100" } }*/
}