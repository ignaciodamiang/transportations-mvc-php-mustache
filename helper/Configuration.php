<?php
include_once("helper/MysqlDatabase.php");
include_once("helper/Render.php");
include_once("helper/UrlHelper.php");
include_once("helper/VerificacionDeRolModel.php");

include_once("model/GerenteModel.php");
include_once("model/registroModel.php");
include_once("model/UsuarioModel.php");
include_once("model/loginModel.php");
include_once("model/AdminModel.php");
include_once("model/ChoferModel.php");
include_once("model/MecanicoModel.php");


include_once("controller/GerenteController.php");
include_once("controller/registroController.php");
include_once("controller/loginController.php");
include_once("controller/AdminController.php");
include_once("controller/LoginController.php");
include_once("controller/ChoferController.php");
include_once("controller/MecanicoController.php");

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
        $verificacionDeRolModel = $this->getVerificacionDeRolModel();
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
        $usuarioModel = $this->getUsuarioModel();
        $verificacionRolModel = $this->getVerificacionDeRolModel();
        $GerenteModel = $this->getGerenteModel();

        return new AdminController($adminModel, $this->getRender(),$verificacionRolModel,$usuarioModel, $GerenteModel);
    }

    public function getGerenteModel()
    {
        $database = $this->getDatabase();
        return new GerenteModel($database);
    }

    public function getGerenteController()
    {
        $gerenteModel = $this->getGerenteModel();
        $usuarioModel = $this->getUsuarioModel();
        $verificacionRolModel = $this->getVerificacionDeRolModel();

        return new GerenteController($gerenteModel, $this->getRender(),$verificacionRolModel,$usuarioModel);
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


    public function getChoferModel()
    {
        $database = $this->getDatabase();
        return new ChoferModel($database);
    }

    public function getChoferController()
    {
        $ChoferModel = $this->getChoferModel();
        $usuarioModel = $this->getUsuarioModel();
        $verificacionRolModel = $this->getVerificacionDeRolModel();
        return new ChoferController($ChoferModel,$this->getRender(),$usuarioModel,$verificacionRolModel);
    }

        public function getMecanicoModel()
    {
        $database = $this->getDatabase();
        return new MecanicoModel($database);
    }

    public function getMecanicoController()
    {
        $MecanicoModel = $this->getMecanicoModel();
        $usuarioModel = $this->getUsuarioModel();
        $verificacionRolModel = $this->getVerificacionDeRolModel();
        return new MecanicoController($MecanicoModel,$this->getRender(),$usuarioModel,$verificacionRolModel);
    }

}