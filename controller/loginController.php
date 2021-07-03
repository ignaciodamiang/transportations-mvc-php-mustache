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
                $_SESSION["Usuario"] = $email;
                header("location:/gerente");
            }
            if ($this->verificacionDeRolModel->esChofer($rolDelUsuario)) {
                $_SESSION["Usuario"] = $email;
                header("location:/chofer");
            }
            if ($this->verificacionDeRolModel->esMecanico($rolDelUsuario)) {
                $_SESSION["Usuario"] = $email;
                header("location:/mecanico");
            }

        } else {
            header("location:/");
        }


    }
}