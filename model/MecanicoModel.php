<?php

class MecanicoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getListaDeVehiculosEnReparacion($idMecanico){
        $sql = "select * 
                from services 
                inner join vehiculo on services.id_vehiculo = vehiculo.id
                where vehiculo.en_reparacion = 1 and services.id_usuario='$idMecanico'";
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
                    `repuestos` = '$repuesto' 
                WHERE (`id` = '$idService')";

        $this->database->execute($sql);
    }

    public function getIdVehiculoPorService($idService){

            $sql="SELECT Vehiculo.id 
                    from Services inner join Vehiculo on Services.id_vehiculo = Vehiculo.id
                    where Services.id = $idService";
            return $this->database->query($sql);
    }

    public function vehiculoArreglado($idService){

        $idVehiculo["idVehiculo"]=$this->getIdVehiculoPorService($idService);
        $id=$idVehiculo["idVehiculo"]["0"]["id"];

        $sql="UPDATE `transporteslamatanza`.`Vehiculo` 
                SET `en_reparacion` = '0' 
                WHERE (`id` = '$id')";
            
        $this->database->execute($sql);
    }

    
}