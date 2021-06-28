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

    public function getAsignarNuevoRol($idRol, $idUsuario)
    {

        $sql = " UPDATE Usuario SET id_tipoUsuario =$idRol WHERE id= $idUsuario";
        return $this->database->query($sql);

    }

    public function registrarVehiculo($patente,$tipoVehiculo)
    {

        $sql2 = "INSERT INTO Vehiculo (patente,id_tipoVehiculo)
VALUES( '$patente',
        '$tipoVehiculo')";
        $this->database->query($sql2);


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
        $sql="SELECT * FROM Vehiculo";
        $consulta = $this->database->query($sql);
        return $consulta;
    }

}