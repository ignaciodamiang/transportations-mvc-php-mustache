<?php

class MecanicoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getListaDeVehiculosEnReparacion($idMecanico)
    {
        $sql = "select services.id as idServices, vehiculo.patente,vehiculo.marca,vehiculo.modelo ,vehiculo.año_Fabricacion
            from services 
            inner join vehiculo on services.id_vehiculo = vehiculo.id
            where vehiculo.en_reparacion = 1 and services.id_usuario='$idMecanico' and services.services_terminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getservicePorId($idService)
    {
        $sql = "SELECT * FROM Services 
                WHERE id = '$idService'";
        return $this->database->query($sql);

    }

    public function getIdVehiculoPorService($idService)
    {

        $sql = "SELECT Vehiculo.id 
                    from Services inner join Vehiculo on Services.id_vehiculo = Vehiculo.id
                    where Services.id = $idService";
        return $this->database->query($sql);
    }

    public function cargarService($fecha, $costo, $repuesto, $idService)
    {
        $sql = "UPDATE `transporteslamatanza`.`Services` 
                SET `fecha` = '$fecha', 
                    `kilometros_unidad` = '2', 
                    `costo` = '$costo',
                    `repuestos` = '$repuesto',
                    `services_terminado`= '1'
                WHERE (`id` = '$idService')";

        $this->database->execute($sql);
        $this->cambiarTiempoFueraDeServicioReporte($idService, $fecha, $costo);

    }

    public function cambiarTiempoFueraDeServicioReporte($idService, $fecha, $costo)
    {
        $idVehiculo = $this->getIdVehiculoPorService($idService);

        $sql2 = "SELECT fechaEntrada
        from Services
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["fechaEntrada"] = $this->database->query($sql2);
        $fechaEntrada = $vehiculo["fechaEntrada"]["0"]["fechaEntrada"];

        $dias = (strtotime($fechaEntrada) - strtotime($fecha)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);

        $sql3 = "SELECT * FROM reporteVehiculo
                WHERE id_vehiculo= '$idVehiculo' ";
        $consultaSiExisteReporte = $this->database->query($sql3);


        if (isset($consultaSiExisteReporte) && !empty($consultaSiExisteReporte) && $consultaSiExisteReporte != null) {

            $sql4 = "UPDATE `transporteslamatanza`.`reporteVehiculo` 
                SET `tiempoFueraDeServicio` = '$dias',
                `costoPorKilometroRecorrido` = '$costo'
                WHERE (`id_vehiculo` = '$idVehiculo')";

            $this->database->execute($sql4);
        } else {

            $sql5 = "INSERT INTO reporteVehiculo (tiempoFueraDeServicio, kilometrosVehiculoRecorridos, costoMantenimiento, costoPorKilometroRecorrido, desvios, tiempoEstimadoViaje, tiempoRealDeViaje, id_vehiculo)
VALUES( '$dias',
        '0',
        '0',        
        '0',       
        '0',       
        '0',
        '0',
        '$idVehiculo'
        )";

            return $this->database->execute($sql5);

        }


    }

    public function vehiculoArreglado($idService)
    {

        $idVehiculo["idVehiculo"] = $this->getIdVehiculoPorService($idService);
        $id = $idVehiculo["idVehiculo"]["0"]["id"];

        $sql = "UPDATE `transporteslamatanza`.`Vehiculo` 
                SET `en_reparacion` = '0' 
                WHERE (`id` = '$id')";

        $this->database->execute($sql);
    }

    public function getListaDeVehiculosEnViaje()
    {

        $sql = "SELECT * FROM Vehiculo
                WHERE viaje_asignado= '1' ";
        return $this->database->query($sql);
    }

    public function InformarPosicion($idVehiculo)
    {
        $sql = " SELECT proformaChofer.latitud_actual as 'latitud', proformaChofer.longitud_actual as 'longitud',proformaChofer.direccion_actual as 'direccion'
                from vehiculo
                inner join Viaje on vehiculo.id=viaje.id_vehiculo
                inner join proformaChofer on Viaje.id= proformaChofer.id_viaje
                where vehiculo.id= '$idVehiculo'
                order by (fechaHoraPuntoControl)desc
                limit 1";

        return $this->database->query($sql);
    }


}