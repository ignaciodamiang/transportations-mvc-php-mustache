<?php

class LoginController
{
    private $usuarioModel;
    private $loginModel;
    private $render;
    private $verificacionDeRolModel;

    public function __construct($loginModel, $render, $usuarioModel, $verificacionDeRolModel)
    {
        $this->loginModel = $loginModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificacionDeRolModel = $verificacionDeRolModel;
    }

    public function execute()
    {
        if (isset($_GET["mensaje"])) {

            $mensaje["mensaje"] = $_GET["mensaje"];
            echo $this->render->render("view/login.mustache", $mensaje);
        } else {
            echo $this->render->render("view/login.mustache");

        }
    }

    public function loguearUsuario()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $siTieneRol = $this->loginModel->verificarUsuarioConRol($email, $password);
        if ($siTieneRol) {
            $rolDelUsuario = $this->usuarioModel->getRolUsuario($email);

            if ($this->verificacionDeRolModel->esAdmin($rolDelUsuario)) {

                $_SESSION["Usuario"] = $email;
                header("location:/admin");
            }
            if ($this->verificacionDeRolModel->esGerente($rolDelUsuario)) {

                header("location:/registro");
            }
            if ($this->verificacionDeRolModel->esChofer($rolDelUsuario)) {
                header("location:/registro");
            }
            if ($this->verificacionDeRolModel->esMecanico($rolDelUsuario)) {
                header("location:/registro");
            }

        } else {
            header("location:/");
        }


    }
}