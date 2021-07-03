<?php

class GerenteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarViaje($ciudad_origen, $ciudad_destino, $fecha_inicio,  $fecha_fin, $tiempo_estimado,  $tipo_carga, $km_previsto,  $combustible_estimado,  $id_vehiculo, $id_usuario)
    {

        $sql1 = "INSERT INTO Viaje (ciudad_origen, ciudad_destino, fecha_inicio,  fecha_fin,  tiempo_estimado,  tipo_carga, km_previsto, combustible_estimado, id_vehiculo, id_usuario)
VALUES( 
        '$ciudad_origen',
        '$ciudad_destino',
        '$fecha_inicio',        
        '$fecha_fin',       
        '$tiempo_estimado',       
        '$tipo_carga',
        '$km_previsto',        
        '$combustible_estimado',
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

    public function modificarVehiculo($id, $patente, $NumeroChasis, $NumeroMotor, $marca, $modelo, $año_fabricacion, $kilometraje, $estado, $alarma, $tipoVehiculo){
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

    public function borrarVehiculo($id){
        $sql = "DELETE FROM Vehiculo WHERE id = '$id'";
        $this->database->execute($sql);
    }

}