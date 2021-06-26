<?php

class LoginController
{

    private $loginModel;
    private $render;

    public function __construct($loginModel, $render)
    {
        $this->loginModel = $loginModel;
        $this->render = $render;
    }

    public function execute()
    {
        echo $this->render->render("view/login.mustache");

    }

    public function loguearUsuario()
    {

        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];

        if ($this->loginModel->obtenerUsuarioParaLoguear($email, $contraseña)) {

            $_SESSION["nombre"] = $email;
            echo $this->render->render("view/adminView.mustache");

        } else {
            echo $this->render->render("view/login.mustache");

        }

    }

}