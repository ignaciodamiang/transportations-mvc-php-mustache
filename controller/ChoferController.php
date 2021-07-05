<?php

class ChoferController
{
    private $ChoferModel;
    private $render;
    private $usuarioModel;
    private $verificarRolModel;

    public function __construct($ChoferModel, $render,$usuarioModel,$verificarRolModel)
    {
        $this->ChoferModel = $ChoferModel;
        $this->render = $render;
        $this->usuarioModel = $usuarioModel;
        $this->verificarRolModel = $verificarRolModel;
    }


    public function execute()

    {   
        if ($this->validarSesion() == true) {
            $sesion = $_SESSION["Usuario"];
            $tipoUsuario = $this->usuarioModel->getRolUsuario($sesion);

            $idChofer = $this->usuarioModel->getIdUsuario($sesion);
            $datas = array("viajeEnCurso" => $this->ChoferModel->getViajeEnCurso($idChofer));

            if($this->verificarRolModel->esAdmin($tipoUsuario) || $this->verificarRolModel->esChofer($tipoUsuario) ){               
                echo $this->render->render("view/choferView.mustache",$datas);
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

    public function empezarViaje(){
        /* agreegar isset*/
        $latitud=$_POST["latitud"];;
        $longitud=$_POST["longitud"];;

        $fechaInicioReal= date('y-m-d');
        $horita=new DateTime();
        $horaInicioReal= $horita->format('H:i:s');
        $id_viaje=$_POST["id_viaje"];


        $this->ChoferModel->getEmpezarViaje($id_viaje,$latitud, $longitud,$fechaInicioReal,$horaInicioReal);
        header("location: /chofer");

    }

}