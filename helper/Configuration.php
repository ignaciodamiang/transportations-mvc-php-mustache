<?php
include_once("helper/MysqlDatabase.php");
include_once("helper/Render.php");
include_once("helper/UrlHelper.php");
include_once("helper/VerificacionDeRolModel.php");


include_once("model/registroModel.php");
include_once("model/UsuarioModel.php");
include_once("model/loginModel.php");
include_once("model/AdminModel.php");

include_once("controller/registroController.php");
include_once("controller/loginController.php");
include_once("controller/AdminController.php");
include_once("controller/LoginController.php");
include_once('third-party/mustache.php/src/Mustache/Autoloader.php');
include_once("Router.php");


class Configuration
{

    private function getDatabase()
    {
        $config = $this->getConfig();
        return new MysqlDatabase(
            $config["servername"],
            $config["username"],
            $config["password"],
            $config["dbname"]
        );
    }

    public function getLoginModel()
    {
        $database = $this->getDatabase();
        return new loginModel($database);
    }

    private function getConfig()
    {
        return parse_ini_file("config/config.ini");
    }

    public function getRender()
    {
        return new Render('view/partial');
    }

    public function getLoginController()
    {
        $usuarioModel = $this->getUsuarioModel();
        $loginModel = $this->getLoginModel();
        $verificacionDeRolModel=$this->getVerificacionDeRolModel();
        return new loginController($loginModel, $this->getRender(), $usuarioModel, $verificacionDeRolModel);
    }

    public function getRegistroModel()
    {
        $database = $this->getDatabase();
        return new registroModel($database);
    }

    public function getRegistroController()
    {
        $registroModel = $this->getRegistroModel();
        return new registroController($registroModel, $this->getRender());
    }

    public function getRouter()
    {
        return new Router($this);
    }

    public function getUrlHelper()
    {
        return new UrlHelper();
    }

    public function getAdminModel()
    {
        $database = $this->getDatabase();
        return new AdminModel($database);
    }

    public function getAdminController()
    {
        $adminModel = $this->getAdminModel();
        return new AdminController($adminModel, $this->getRender());
    }

    public function getUsuarioModel()
    {
        $database = $this->getDatabase();
        return new UsuarioModel($database);
    }

    public function getVerificacionDeRolModel()
    {
        $database = $this->getDatabase();
        return new VerificacionDeRolModel($database);
    }
}