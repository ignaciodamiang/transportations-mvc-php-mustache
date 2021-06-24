<?php

class AdminController {
    private $adminModel;
    private $render;

    public function __construct($adminModel, $render){
        $this->adminModel = $adminModel;
        $this->render = $render;
    }

    public function execute(){
        $data["usuariosSinRol"] = $this->adminModel->getUsuariosSinRol();
        echo $this->render->render("view/admin/adminView.mustache", $data);
    }



    public function darRol(){
        $idRol = $_POST['Rol'];
        $idUsuario = $_POST['id'];
        $this->adminModel->getAsignarNuevoRol($idRol,$idUsuario);
        header("location:/admin");
        exit();
    }
}