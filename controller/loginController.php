<?php

class LoginController
{
    private $usuarioModel;
    private $loginModel;
    private $render;
    private $verificacionDeRolModel;

    public function __construct($loginModel, $render, $usuarioModel,$verificacionDeRolModel)
    {
        $this->loginModel = $loginModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificacionDeRolModel=$verificacionDeRolModel;
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
        $contraseña = $_POST["contraseña"];

        if ($this->loginModel->verificarUsuarioConRol($email, $contraseña))
        {
           /* if($this->verificacionDeRolModel->esAdmin($this->usuarioModel->getRolUsuario($email))){
                header("location:/admin");

            }else if ($this->verificacionDeRolModel->esGerente($this->usuarioModel->getRolUsuario($email))){

                header("location:/registro");

            }

        */
            header("location:/admin");
        }
        else {
                header("location:/registro");

            }

    }
}