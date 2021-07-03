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
        $datas = array("usuariosSinRol" => $this->AdminModel->getUsuariosSinRol(), "todosLosVehiculos" => $this->AdminModel->getVehiculos());
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








}
