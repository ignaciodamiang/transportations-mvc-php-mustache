<?php

class registroModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrarUsuario($nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $email, $contraseña)
    {

        $sql = "INSERT INTO Usuario (nombre,apellido,legajo,dni,fecha_nacimiento,tipo_licencia,email,contraseña)
VALUES( '$nombre',
        '$apellido',
        '$legajo',
        '$dni',
        '$fecha_nacimiento',
        '$tipo_licencia',
        '$email',
        '$contraseña')";
        $this->database->query($sql);


    }

    public function getValidarRegistro($dni, $legajo, $email)
    {

        $sql = "SELECT * FROM Usuario where (dni =  '$dni') or (legajo = '$legajo') or (email = '$email')";
        $validarUsuario = $this->database->query($sql);
        if ($validarUsuario == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getActivarCuenta($email)
    {

        $sql = "UPDATE Usuario set cuenta_activada=1 where (email = '$email')";
        $this->database->query($sql);


    }

}