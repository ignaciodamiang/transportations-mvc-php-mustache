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
                                   $CostoViaticos_estimado,
                                   $CostoPeajesEstimado,
                                   $CostoExtrasEstimado,
                                   $CostoFeeEstimado,
                                   $CostoHazardEstimado,
                                   $CostoReeferEstimado,
                                   $CostoTotalEstimado,
                                   $id_arrastre,
                                   $id_vehiculo,
                                   $id_usuario
    )
    {

        $sql1 = "INSERT INTO Viaje (ciudad_origen, ciudad_destino, fecha_inicio,  fecha_fin,  tiempo_estimado,  descripcion_carga, km_previsto, combustible_estimado, precioCombustible_estimado,precioViaticos_estimado, precioPeajes_estimado, precioExtras_estimado, precioFee_estimado, precioHazard_estimado, precioReefer_estimado, precioTotal_estimado,id_arrastre,id_vehiculo, id_usuario)
VALUES( '$ciudad_origen',
        '$ciudad_destino',
        '$fecha_inicio',        
        '$fecha_fin',       
        '$tiempo_estimado',       
        '$tipo_carga',
        '$km_previsto',        
        '$combustible_estimado',
        '$precioCombustibleEstimado',
        '$CostoViaticos_estimado',
        '$CostoPeajesEstimado',
        '$CostoExtrasEstimado',
        '$CostoFeeEstimado',
        '$CostoHazardEstimado',
        '$CostoReeferEstimado',
        '$CostoTotalEstimado',
        '$id_arrastre',
        '$id_vehiculo',
        '$id_usuario'
        )";
        $this->database->execute($sql1);
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

    public function getValidarArrastre($patente)
    {

        $sql = "SELECT * FROM Arrastre where (patente =  '$patente')";
        $validarArrastre = $this->database->query($sql);
        if ($validarArrastre == null) {
            return false;
        } else {
            return true;
        }
    }

    public function registrarArrastre($patente, $NumeroChasis, $tipo, $pesoNeto, $hazard, $reefer, $temperatura)
    {

        $sql2 = "INSERT INTO Arrastre (patente, numeroDeChasis, tipo, peso_Neto, hazard, reefer, temperatura)
VALUES('$patente',
        '$NumeroChasis',
        '$tipo',
        '$pesoNeto',
        '$hazard',
        '$reefer',
        '$temperatura')";
        $this->database->execute($sql2);
    }

    public function getListaArrastre()
    {
        $sql = "SELECT * FROM Arrastre";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

    public function getVehiculos()
    {
        $sql = "SELECT * FROM Vehiculo";
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
        $sql = "DELETE FROM Vehiculo WHERE id = '$id'";
        $this->database->execute($sql);
    }


    public function getListaDeChoferes()
    {
        $sql = "SELECT * FROM Usuario WHERE id_tipoUsuario = '3'";
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

    public function getValidarViaje($fechaPartidaEstimada, $fechaLlegadaEstimada, $idChofer){
        $sql = "SELECT * FROM Viaje where fecha_inicio='$fechaPartidaEstimada' and fecha_fin='$fechaLlegadaEstimada'and id_usuario='$idChofer'";
        $validarViaje = $this->database->query($sql);
        if ($validarViaje == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getIdViaje($ciudadOrigen, $ciudadDestino, $fechaPartidaEstimada, $fechaLlegadaEstimada, $idChofer){
        $sql = "SELECT * FROM Viaje where (ciudad_origen='$ciudadOrigen') AND (ciudad_destino='$ciudadDestino') AND (fecha_inicio='$fechaPartidaEstimada') AND (fecha_fin='$fechaLlegadaEstimada') AND (id_usuario='$idChofer')";
        $this->database->execute($sql);
        $resultado["id_viaje"] = $this->database->query($sql);
        return $resultado["id_viaje"]["0"]["id"];

    }
}