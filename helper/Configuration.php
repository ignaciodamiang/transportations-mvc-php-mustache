<?php
include_once("helper/MysqlDatabase.php");
include_once("helper/Render.php");
include_once("helper/UrlHelper.php");

include_once("model/UserModel.php");

include_once("controller/IndexController.php");
include_once("controller/LoginController.php");
include_once("controller/UserController.php");

include_once('third-party/mustache.php/src/Mustache/Autoloader.php');
include_once("Router.php");

class Configuration{

    private function getDatabase(){
        $config = $this->getConfig();
        return new MysqlDatabase(
            $config["servername"],
            $config["username"],
            $config["password"],
            $config["dbname"]
        );
    }

    private function getConfig(){
        return parse_ini_file("config/config.ini");
    }

    public function getRender(){
        return new Render('view/partial');
    }

    public function getInicioController(){
        return new indexController($this->getRender());
    }

    public function getLoginController(){
        return new loginController($this->getRender());
    }

    public function getRouter(){
        return new Router($this);
    }

    public function getUrlHelper(){
        return new UrlHelper();
    }

    public function getUsuariosModel(){
        $database = $this->getDatabase();
        return new UserModel($database);
    }

    public function getUsariosController(){
        $todosLosUsuarios = $this->getUsuarios();
        return new UserController($todosLosUsuarios, $this->getRender());
    }


}