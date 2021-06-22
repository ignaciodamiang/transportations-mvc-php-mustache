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
        echo $this->render->render("view/adminView.mustache", $data);
    }

}