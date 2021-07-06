<?php

class AdminController
{
    private $verificarRolModel;
    private $AdminModel;
    private $usuarioModel;
    private $render;

    public function __construct($AdminModel, $render,$verificarRolModel,$usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
        $this->AdminModel = $AdminModel;
        $this->render = $render;
    }


    public function execute()
    {
        $datas = array("usuariosSinRol" => $this->AdminModel->getUsuariosSinRol());
        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if($this->verificarRolModel->esAdmin($tipoUsuario)){
                echo $this->render->render("view/admin/adminView.mustache", $datas);
            }else{
                $this->cerrarSesion();
                header("location:/login");
            }
            

        } else {
            header("location:/login");
        }

    }

        public function verTodosLosUsuarios(){
        $datas = array("todosLosUsuarios" => $this->AdminModel->getUsuarios());

            if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if($this->verificarRolModel->esAdmin($tipoUsuario)){
                echo $this->render->render("view/admin/todosLosUsuariosView.mustache", $datas);
            }else{
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

    public function irModificarUsuario(){
        $id = $_POST["idUsuario"];
        $data["usuario"]= $this->AdminModel->getUsuarioPorId($id);

        if ($data != null) {
            echo $this->render->render("view/admin/modificarUsuarioView.mustache", $data);

        }else{
            header("location:/admin?noRedirecciono");
        }
    }

    public function modificarUsuario(){
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

        if(isset( $_POST["idUsuario"])){

            if ($this->AdminModel->getUsuarioPorId($id)) {
                $this->AdminModel->modificarUsuario($id, $nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $id_tipoUsuario, $email, $contrasenia);
                header("location:/admin?usuarioModificado");
            }else{
                header("location:/admin?errorAlModificarUsuario");
            }

        }else{
            header("location:/admin?errorAlModificarUsuario");
        }

    }

    public function borrarUsuario(){
        $idUsuario = $_POST["idUsuario"];

        if ($this->validarSesion() == true) {

            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            if($this->verificarRolModel->esAdmin($tipoUsuario)){
                if ($this->AdminModel->getUsuarioPorId($idUsuario)) {
                    $this->AdminModel->borrarUsuario($idUsuario);
                    header("location: ../admin?usuarioBorrado");
                }else{
                    header("location: ../admin?usuarioNoBorrado");
                }
            }else{
                $this->cerrarSesion();
                header("location:/login");
            }
        } else {
            header("location:/login");
        }
    }
}
