<?php

class AdminController
{
    private $verificarRolModel;
    private $AdminModel;
    private $usuarioModel;
    private $GerenteModel;
    private $render;

    public function __construct($AdminModel, $render, $verificarRolModel, $usuarioModel, $GerenteModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
        $this->AdminModel = $AdminModel;
        $this->GerenteModel = $GerenteModel;
        $this->render = $render;
    }


    public function data()
    {
        $urlRegistrarViaje = "admin/registrarViaje";
        $datas = array("usuariosSinRol" => $this->AdminModel->getUsuariosSinRol(), "todosLosVehiculos" => $this->GerenteModel->getVehiculos(), "vehiculosSinUso" => $this->GerenteModel->getVehiculosSinUso(), "todosLosChoferes" => $this->GerenteModel->getListaDeChoferes(), "todosLosViajes" => $this->GerenteModel->getViajes(), "urlRegistrarViaje" => $urlRegistrarViaje, "url" => "../admin");
        $datas["rol"] = "Administrador";
        $datas["iconoUsuariosSinRol"] = 'M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z';
        $datas["iconoUsuariosSinRol2"] = 'M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z';
        $datas["usuariosSinRolBoton"] = "Dar rol a usuario";
        $datas["rutaUsuariosSinRol"] = "../admin";
        $datas["iconoPrimerBoton"] = 'M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z';
        $datas["iconoPrimerBoton2"] = 'M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z';
        $datas["primerBoton"] = "Viajes";
        $datas["rutaPrimerBoton"] = "../admin";
        $datas["iconoSegundoBoton"] = 'M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z';
        $datas["iconoSegundoBoton2"] = 'M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z';
        $datas["segundoBoton"] = "Registrar Viaje";
        $datas["rutaSegundoBoton"] = "../admin/registrarViaje";
        $datas["iconoTercerBoton"] = 'M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z';
        $datas["tercerBoton"] = "Vehiculos";
        $datas["rutaTercerBoton"] = "../admin/vehiculos";
        $datas["iconoCuartoBoton"] = 'M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z';
        $datas["iconoCuartoBoton2"] = 'M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z';
        $datas["cuartoBoton"] = "Registrar Vehiculo";
        $datas["rutaCuartoBoton"] = "../admin/registrarVehiculo";
        $datas["iconoQuintoBoton"] = 'M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 11.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z';
        $datas["quintoBoton"] = "Reporte estadísticas de vehículos";
        $datas["rutaQuintoBoton"] = "../admin/estadisticasVehiculos";

        $sesion = $_SESSION["Usuario"];
        $id = $this->usuarioModel->getIdUsuario($sesion);
        $this->usuarioModel->getNombreUsuario($id);
        $datas["nombre"] = $this->usuarioModel->getNombreUsuario($id);
        $datas["apellido"] = $this->usuarioModel->getApellidoUsuario($id);

        return $datas;
    }

    public function execute()
    {

        $datas = $this->data();

        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario)) {
                echo $this->render->render("view/admin/adminView.mustache", $datas);
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }


        } else {
            header("location:/login");
        }

    }

    public function verTodosLosUsuarios()
    {
        $datas = $this->data();
        $datas["todosLosUsuarios"] = $this->AdminModel->getUsuarios();

        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario)) {
                echo $this->render->render("view/admin/todosLosUsuariosView.mustache", $datas);
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }


        } else {
            header("location:/login");
        }
    }

    public function validarSesion()
    {
        $sesion = $_SESSION["Usuario"];

        if ($sesion == null || $sesion = '' || !isset($sesion)) {
            return false;
        } else {

            return true;
        }
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("location:/login");
    }

    public function darRol()
    {
        $sesion = $_SESSION["Usuario"];

        $idRol = $_POST['Rol'];
        $idUsuario = $_POST['id'];
        $this->AdminModel->getAsignarNuevoRol($idRol, $idUsuario);
        header("location:/admin");
        exit();
    }

    public function irModificarUsuario()
    {
        $data = $this->data();
        $id = $_POST["idUsuario"];
        $data["usuario"] = $this->AdminModel->getUsuarioPorId($id);

        if ($data != null) {
            echo $this->render->render("view/admin/modificarUsuarioView.mustache", $data);

        } else {
            header("location:../admin");
        }
    }

    public function modificarUsuario()
    {
        $datas = $this->data();
        $id = $_POST["idUsuario"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $legajo = $_POST["legajo"];
        $dni = $_POST["dni"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $tipo_licencia = $_POST["tipo_licencia"];
        $id_tipoUsuario = $_POST["id_tipoUsuario"];
        $email = $_POST["email"];
        $contrasenia = $_POST["contrasenia"];

        if (isset($_POST["idUsuario"])) {

            if ($this->AdminModel->getUsuarioPorId($id)) {
                $this->AdminModel->modificarUsuario($id, $nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $id_tipoUsuario, $email, $contrasenia);
                header("location:/admin?usuarioModificado");
            } else {
                header("location:/admin?errorAlModificarUsuario");
            }

        } else {
            header("location:/admin?errorAlModificarUsuario");
        }

    }

    public function borrarUsuario()
    {
        $idUsuario = $_POST["idUsuario"];

        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if ($this->verificarRolModel->esAdmin($tipoUsuario)) {
                if ($this->AdminModel->getUsuarioPorId($idUsuario)) {
                    $this->AdminModel->borrarUsuario($idUsuario);
                    header("location: ../admin?usuarioBorrado");
                } else {
                    header("location: ../admin?usuarioNoBorrado");
                }
            } else {
                $this->cerrarSesion();
                header("location:/login");
            }
        } else {
            header("location:/login");
        }
    }
}
