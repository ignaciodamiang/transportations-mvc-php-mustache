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
                WHERE id_usuario = '3' and viaje_enCurso =0";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getEmpezarViaje($id_viaje,$latitud, $longitud,$fechaInicioReal,$horaInicioReal){
        $sql="UPDATE `transporteslamatanza`.`Viaje` 
                SET `latitud_inicio` = '$latitud', `longitud_inicio` = '$longitud' ,
                fecha_inicioReal='$fechaInicioReal', hora_inicio='$horaInicioReal',
                viaje_enCurso= '1'
                WHERE (`id` = '$id_viaje')";
        $this->database->execute($sql);

    }

    public function recargaCombustible($combustible_real,$precioCombustible_real,$id_viaje){

        $sql= "INSERT INTO `transporteslamatanza`.`ProformaChofer` (`combustible_actual`, `precioCombustible_actual`, `id_viaje`)   
        VALUES ( '$combustible_real', '$precioCombustible_real', '$id_viaje')";
        $this->database->execute($sql);
    }

    public function gastoPeajeYExtra($precioPeajes_actual,$precioExtras_actual,$precioViaticos_actual,$id_viaje){

            $sql= "INSERT INTO `transporteslamatanza`.`ProformaChofer` (`precioPeajes_actual`, `precioExtras_actual`,`precioViaticos_actual`, `id_viaje`)   
            VALUES ( '$precioPeajes_actual', '$precioExtras_actual','$precioViaticos_actual', '$id_viaje')";
            $this->database->execute($sql);
        

    }

}