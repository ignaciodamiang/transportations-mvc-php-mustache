<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuarios()
    {
        return $this->database->query("SELECT * FROM usuario");
    }

    public function getUsuariosSinRol()
    {
        $sql = "SELECT * FROM usuario WHERE id_tipoUsuario IS NULL";
        $consulta = $this->database->query($sql);
        if (sizeof($consulta) != 0) {
            return $consulta;
        } else
            return false;
    }

    public function getUsuarioPorId($id)
    {
        $sql = "SELECT * FROM usuario where id = " . $id;
        return $this->database->query($sql);
    }

    public function getUsuarioPorEmail($email)
    {

        $sql = "SELECT * FROM Usuario where email = '$email'";
        return $this->database->query($sql);

    }

    public function getAsignarNuevoRol($idRol, $idUsuario)
    {

        $sql = " UPDATE Usuario SET id_tipoUsuario =$idRol WHERE id= $idUsuario";
        return $this->database->query($sql);

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
   
    public function modificarVehiculo($id,$patente,$tipoVehiculo){
        $sql = "UPDATE Vehiculo 
                SET patente = '$patente', id_tipoVehiculo = '$tipoVehiculo' 
                WHERE id = '$id'";

        $this->database->execute($sql);
        
    }

    public function borrarVehiculo($id){
        $sql = "DELETE FROM Vehiculo WHERE id = '$id'";
        $this->database->execute($sql);
    }

}