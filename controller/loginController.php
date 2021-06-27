<?php

class LoginController
{
    private $usuarioModel;
    private $loginModel;
    private $render;

    public function __construct($loginModel, $render, $usuarioModel)
    {
        $this->loginModel = $loginModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
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
        /* verifico que el usuario exista y tenga rol
        */
        if ($this->loginModel->verificarUsuarioConRol($email, $contraseña)) {
        /* $data["rol"]= $this->usuarioModel->getRolUsuario($email);

            if( $data["rol"][0] == 1 ){
                $_SESSION["nombre"] = $email;*/
                header("location:/admin");
            /*}
            else{
                header("location:/registro");
            }

*/
        } else {
            header("location:/");

        }

    }

}