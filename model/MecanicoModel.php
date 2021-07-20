<?php

class MecanicoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getListaDeVehiculosEnReparacion($idMecanico){
        $sql = "select services.id as idServices, vehiculo.patente,vehiculo.marca,vehiculo.modelo ,vehiculo.año_Fabricacion
                from services 
                inner join vehiculo on services.id_vehiculo = vehiculo.id
                where vehiculo.en_reparacion = 1 and services.id_usuario='$idMecanico' and services.services_terminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getservicePorId($idService){
        $sql="SELECT * FROM Services 
                WHERE id = '$idService'";
        return $this->database->query($sql);

    }

    public function cargarService($fecha, $costo, $repuesto, $idService){
        $sql="UPDATE `transporteslamatanza`.`Services` 
                SET `fecha` = '$fecha', 
                    `kilometros_unidad` = '2', 
                    `costo` = '$costo',
                    `repuestos` = '$repuesto', 
                    `services_terminado`= '1'
                WHERE (`id` = '$idService')";

        $this->database->execute($sql);
    }

    public function getIdVehiculoPorService($idService){

            $sql="SELECT vehiculo.id as 'idVehiculo'
                    from vehiculo inner join services on vehiculo.id = services.id_vehiculo
                    where services.id= $idService";
            return $this->database->query($sql);
    }

    public function vehiculoArreglado($idService){

        $idVehiculo["idVehiculo"]=$this->getIdVehiculoPorService($idService);
        $id=$idVehiculo["idVehiculo"]["0"]["idVehiculo"];

        $sql="UPDATE `transporteslamatanza`.`Vehiculo` 
                SET `en_reparacion` = '0' 
                WHERE (`id` = '$id')";
            
        $this->database->execute($sql);
    }

    public function getListaDeVehiculosEnViaje(){

        $sql= "SELECT * FROM Vehiculo
                WHERE viaje_asignado= '1' ";
        return $this->database->query($sql);
    }

    public function InformarPosicion($idVehiculo){
        $sql=" SELECT proformaChofer.latitud_actual as 'latitud', proformaChofer.longitud_actual as 'longitud',proformaChofer.direccion_actual as 'direccion'
                from vehiculo
                inner join Viaje on vehiculo.id=viaje.id_vehiculo
                inner join proformaChofer on Viaje.id= proformaChofer.id_viaje
                where vehiculo.id= '$idVehiculo'
                order by (fechaHoraPuntoControl)desc
                limit 1";

        return $this->database->query($sql);
    }

    
}