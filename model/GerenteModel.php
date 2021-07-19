<?php

class GerenteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarViaje($ciudad_origen,
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
    )
    {

        $sql1 = "INSERT INTO Viaje (ciudad_origen, ciudad_destino, fecha_inicio, fecha_fin, tiempo_estimado,  descripcion_carga, km_previsto, combustible_estimado, precioCombustible_estimado, costoTotalCombustible_estimado, precioViaticos_estimado, precioPeajes_estimado, precioExtras_estimado, fee_estimado, peso_Neto, hazard, precioHazard_estimado, reefer, precioReefer_estimado, temperatura, precioTotal_estimado, id_vehiculo, id_usuario)
VALUES( '$ciudad_origen',
        '$ciudad_destino',
        '$fecha_inicio',        
        '$fecha_fin',       
        '$tiempo_estimado',       
        '$tipo_carga',
        '$km_previsto',        
        '$combustible_estimado',
        '$precioCombustibleEstimado',
        '$costoTotalCombustibleEstimado',
        '$CostoViaticos_estimado',
        '$CostoPeajesEstimado',
        '$CostoExtrasEstimado',
        '$feeEstimado',
        '$peso_Neto',
        '$hazard',
        '$CostoHazardEstimado',
        '$reefer',
        '$CostoReeferEstimado',
        '$temperatura',
        '$CostoTotalEstimado',
        '$id_vehiculo',
        '$id_usuario'
        )";
        return $this->database->execute($sql1);
    }

    public function modificarViaje($id, $ciudad_origen, $ciudad_destino, $fecha_inicio, $fecha_fin, $tiempo_estimado, $descripcion_carga, $km_previsto, $combustible_estimado, $precioViaticos_estimado, $precioPeajes_estimado, $precioExtras_estimado, $precioCombustible_estimado, $costoTotalCombustible_estimado, $peso_Neto, $hazard, $precioHazard_estimado, $reefer, $precioReefer_estimado, $fee_estimado, $temperatura, $precioTotal_estimado, $id_vehiculo, $id_usuario)
    {
        $sql = "UPDATE Viaje 
                SET
                ciudad_origen = '$ciudad_origen',
                ciudad_destino = '$ciudad_destino',
                fecha_inicio = '$fecha_inicio',
                fecha_fin = '$fecha_fin',
                peso_Neto = '$peso_Neto',
                hazard = '$hazard',
                reefer = '$reefer',
                temperatura = '$temperatura',
                tiempo_estimado = '$tiempo_estimado',
                km_previsto = '$km_previsto',
                descripcion_carga = '$descripcion_carga',
                combustible_estimado = '$combustible_estimado',
                precioCombustible_estimado = '$precioCombustible_estimado',
                costoTotalCombustible_estimado = '$costoTotalCombustible_estimado',
                precioViaticos_estimado = '$precioViaticos_estimado',
                precioPeajes_estimado = '$precioPeajes_estimado',
                precioExtras_estimado = '$precioExtras_estimado',
                fee_estimado = '$fee_estimado',
                precioHazard_estimado = '$precioHazard_estimado',
                precioReefer_estimado = '$precioReefer_estimado',
                precioTotal_estimado = '$precioTotal_estimado',
                id_vehiculo = '$id_vehiculo',
                id_usuario = '$id_usuario'
                WHERE id = '$id'";

        $this->database->execute($sql);
    }

    public function borrarViaje($id)
    {
        $sql = "UPDATE Viaje 
                SET
                viaje_eliminado = '1'
                WHERE id = '$id'";
        $this->database->execute($sql);
    }

    public function registrarVehiculo($patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo)
    {

        $sql2 = "INSERT INTO Vehiculo (patente, numero_chasis, numero_motor, marca, modelo, año_Fabricacion, kilometraje, estado, alarma, id_tipoVehiculo)
VALUES( 
        '$patente',
        '$NumeroChasis',
        '$NumeroMotor',
        '$marca',
        '$modelo',
        '$año_fabricacion',
        '$kilometraje',
        '$estado',
        '$alarma',
        '$tipoVehiculo')";
        $this->database->execute($sql2);
    }

    public function getValidarVehiculo($patente)
    {
        $sql = "SELECT * FROM Vehiculo where (patente =  '$patente')";
        $validarVehiculo = $this->database->query($sql);
        if ($validarVehiculo == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getVehiculos()
    {
        $sql = "SELECT * FROM Vehiculo
                WHERE vehiculo_eliminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getVehiculosPorId($id)
    {
        $sql = "SELECT * FROM Vehiculo WHERE id = '$id'";
        $consulta = $this->database->query($sql);

        if ($consulta == null) {
            return false;
        } else {
            return $consulta;
        }

    }

    public function getVehiculosSinUso()
    {
        $sql = "SELECT * FROM Vehiculo
                WHERE viaje_asignado = '0'  and en_reparacion = '0' and vehiculo_eliminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function modificarVehiculo($id, $patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo)
    {
        $sql = "UPDATE Vehiculo 
                SET
                patente = '$patente',
                numero_chasis = '$NumeroChasis',
                numero_motor = '$NumeroMotor',
                marca = '$marca',
                modelo = '$modelo',
                año_Fabricacion = '$año_fabricacion',
                kilometraje = '$kilometraje',
                estado = '$estado',
                alarma = '$alarma',
                id_tipoVehiculo = '$tipoVehiculo' 
                WHERE id = '$id'";

        $this->database->execute($sql);

    }

    public function borrarVehiculo($id)
    {
        $sql = "UPDATE Vehiculo 
                SET
                vehiculo_eliminado = 1
                WHERE id = '$id'";
        $this->database->execute($sql);
    }

    public function getListaDeChoferes()
    {
        $sql = "SELECT * FROM Usuario 
                WHERE id_tipoUsuario = '3'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getListaDeChoferesSinViajes()
    {
        $sql = "SELECT * FROM Usuario 
                WHERE id_tipoUsuario = '3' and viaje_asignado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function registrarCliente($nombre, $apellido)
    {
        $sql = "INSERT INTO Cliente (nombre, apellido)
VALUES('$nombre',
        '$apellido')";
        $this->database->execute($sql);

    }

    public function generarFactura($monto, $id_viaje, $id_cliente)
    {
        $sql = "INSERT INTO Factura (monto, id_viaje, id_cliente)
        VALUES('$monto',
        '$id_viaje',
        '$id_cliente')";
        $this->database->execute($sql);
    }


    public function getIdCliente($nombre, $apellido)
    {
        $sql = "SELECT * FROM Cliente where (nombre='$nombre') AND (apellido ='$apellido')";
        $this->database->execute($sql);
        $resultado["id_cliente"] = $this->database->query($sql);
        return $resultado["id_cliente"]["0"]["id"];

    }

    public function getIdViaje($ciudadOrigen, $ciudadDestino, $fechaPartidaEstimada, $fechaLlegadaEstimada, $idChofer)
    {
        $sql = "SELECT * FROM Viaje where (ciudad_origen='$ciudadOrigen') AND (ciudad_destino='$ciudadDestino') AND (fecha_inicio='$fechaPartidaEstimada') AND (fecha_fin='$fechaLlegadaEstimada') AND (id_usuario='$idChofer')";
        $this->database->execute($sql);
        $resultado["id_viaje"] = $this->database->query($sql);
        return $resultado["id_viaje"]["0"]["id"];

    }

    public function getViajes()
    {
        $sql = "SELECT * FROM Viaje
                WHERE viaje_eliminado = '0'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getViajePorId($id)
    {
        $sql = "SELECT * FROM viaje WHERE id = " . $id;
        return $this->database->query($sql);
    }


    public function asignarViajeChofer($id_usuario)
    {

        $sql = "UPDATE `transporteslamatanza`.`Usuario` 
                SET `viaje_asignado` = '1'
                WHERE (`id` = '$id_usuario')";

        $this->database->execute($sql);

    }

    public function asignarViajeVehiculo($id_vehiculo)
    {

        $sql = "UPDATE `transporteslamatanza`.`Vehiculo` 
                SET `viaje_asignado` = '1'
                WHERE (`id` = '$id_vehiculo')";

        $this->database->execute($sql);
    }

    public function getNombreClientePorId($id)
    {
        $sql = "SELECT * FROM Cliente where (id='$id')";
        $this->database->execute($sql);
        $resultado["nombreCliente"] = $this->database->query($sql);
        return $resultado["nombreCliente"]["0"]["nombre"];

    }

    public function getApellidoClientePorId($id)
    {
        $sql = "SELECT * FROM Cliente where (id='$id')";
        $this->database->execute($sql);
        $resultado["apellidoCliente"] = $this->database->query($sql);
        return $resultado["apellidoCliente"]["0"]["apellido"];

    }

    public function getClienteFactura($id_viaje)
    {
        $sql = "SELECT * FROM Factura where (id_viaje='$id_viaje')";
        $this->database->execute($sql);
        $resultado["idCliente"] = $this->database->query($sql);
        return $resultado["idCliente"]["0"]["id_cliente"];

    }

    public function guardarInforme($informe, $id_viaje)
    {
        $sql = "UPDATE `transporteslamatanza`.`Viaje` 
                SET `informe` = '$informe'
                WHERE (`id` = '$id_viaje')";

        $this->database->execute($sql);

    }

    public function getMecanicos()
    {
        $sql = "SELECT * FROM Usuario
                WHERE id_tipoUsuario = '4'";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function mandarAServices($idVehiculo, $idMecanico)
    {

        $sql = "INSERT INTO Services (id_vehiculo, id_usuario)
VALUES('$idVehiculo',
        '$idMecanico')";
        $this->database->execute($sql);

    }

    public function cambiarEstadoVehiculoAEnReparacion($idVehiculo)
    {

        $sql = "UPDATE `transporteslamatanza`.`Vehiculo` 
                SET `en_reparacion` = '1'
                WHERE (`id` = '$idVehiculo')";

        $this->database->execute($sql);

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

    public function tiempoFueraDeServicio($idVehiculo)
    {

        $sql = "SELECT fecha_finReal
        from Viaje
        where  id_vehiculo = '$idVehiculo'";

        $vehiculo["fecha_finReal"] = $this->database->query($sql);
        $fechaFinalViajeVehiculo = $vehiculo["fecha_finReal"]["0"]["fecha_finReal"];
        $fechaHoy = date('y-m-d');

        $dias = (strtotime($fechaFinalViajeVehiculo) - strtotime($fechaHoy)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);

        return $dias;
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
        return $this->database->query($sql);

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

}