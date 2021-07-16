<?php

class MecanicoController
{
    private $MecanicoModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($MecanicoModel, $render,$usuarioModel,$verificarRolModel)
    {
        $this->MecanicoModel = $MecanicoModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
    }


    public function execute()

    {
        var_dump($this->MecanicoModel->getListaDeVehiculosEnReparacion());
        $datas = array("vehiculosEnReparacion" => $this->MecanicoModel->getListaDeVehiculosEnReparacion());

        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);



            if($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esMecanico($tipoUsuario) ){
                  echo $this->render->render("view/mecanicoView.mustache",$datas);
            }

            else {
                $this->cerrarSesion();
                header("location:/login");
            }

        } else {
            header("location:/login");
        }
    }

    public function validarSesion()
    {
        $sesion = $_SESSION["Usuario"];

        if ($sesion == null || $sesion = '' || !isset($sesion)) {
            return false;
        } else {
            return true;
        }
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("location:/login");
    }


}