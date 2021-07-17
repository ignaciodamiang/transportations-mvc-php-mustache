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
        $sql = "SELECT * FROM usuario WHERE id_tipoUsuario IS NULL and cuenta_activada = 1";
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
        return $this->database->execute($sql);

    }

    public function modificarUsuario($id, $nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $id_tipoUsuario, $email, $contrasenia)
    {
        $sql = "UPDATE Usuario 
                    SET
                    nombre = '$nombre',
                    apellido = '$apellido',
                    legajo = '$legajo',
                    dni = '$dni',
                    fecha_nacimiento = '$fecha_nacimiento',
                    tipo_licencia = '$tipo_licencia',
                    id_tipoUsuario = '$id_tipoUsuario',
                    email = '$email',
                    contraseña = '$contrasenia'
                    WHERE id = '$id'";

        $this->database->execute($sql);

    }

    public function borrarUsuario($id)
    {
        $sql = "DELETE FROM Usuario WHERE id = '$id'";
        $this->database->execute($sql);
    }
}