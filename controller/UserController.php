<?php

class UserController {
    private $userModel;
    private $render;

    public function __construct($userModel, $render){
        $this->userModel = $userModel;
        $this->render = $render;
    }

    public function execute(){
        $data["usuarios"] = $this->userModel->getUsuarios();
        echo $this->render->render("view/inicio.mustache", $data);
    }

}