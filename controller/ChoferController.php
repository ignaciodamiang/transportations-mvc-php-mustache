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

            $IdViaje=$this->ChoferModel->getViajeDelChofer($idChofer);
            $datas = array("viajeEnCurso" => $this->ChoferModel->getViajeEnCurso($idChofer),"historialPuntoDeControl" => $this->ChoferModel->getProforma($IdViaje),
                            "sumaTotalPuntoDeControl" => $this->ChoferModel->getSumaTotalProforma($IdViaje));

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
        $latitud_inicio=$_POST["latitud_inicio"];
        $longitud_inicio=$_POST["longitud_inicio"];

        if ($latitud_inicio==null) {
            $latitud_inicio=0;
        }

        if ( $longitud_inicio==null) {
            $longitud_inicio =0;
        }
   
        $fechaInicioReal= date('y-m-d');
        $horita=new DateTime();
        $horaInicioReal= $horita->format('H:i:s');
        $id_viaje=$_POST["id_viaje"];

        $this->ChoferModel->getEmpezarViaje($id_viaje,$latitud_inicio, $longitud_inicio,$fechaInicioReal,$horaInicioReal);
        $this->ChoferModel->cargaProforma($id_viaje);
        header("location: /chofer");

    }




    public function recargaCombustible(){
        $combustible_real = $_POST["combustible_real"];
        $precioCombustible_real = $_POST["precioCombustible_real"];
        $id_viaje = $_POST["id_viaje"];

        $horita=date('Y-m-d H:i:s');

        $this->ChoferModel->recargaCombustible($combustible_real,$precioCombustible_real,$id_viaje,$horita);
        header("location: /chofer?funciona");
    }

    public function gastoPeajeYExtra(){

        $precioPeajes_actual =$_POST["precioPeajes_actual"];
        $precioExtras_actual =$_POST["precioExtras_actual"];
        $precioViaticos_actual =$_POST["precioViaticos_actual"];
        $id_viaje = $_POST["id_viaje"];

        if ($precioPeajes_actual==null) {
            $precioPeajes_actual=0;
        }

        if ( $precioExtras_actual==null) {
            $precioExtras_actual =0;
        }
   
        if ( $precioViaticos_actual==null) {
            $precioViaticos_actual =0;
        }

        $horita=date('Y-m-d H:i:s');
       

        $this->ChoferModel->gastoPeajeYExtra($precioPeajes_actual,$precioExtras_actual,$precioViaticos_actual,$id_viaje,$horita);
        header("location: /chofer?funciona");
    }

    public function informarPosicion(){
        /* agreegar isset*/
        $latitud_actual=$_POST["latitud_actual"];
        $longitud_actual=$_POST["longitud_actual"];
        $id_viaje = $_POST["id_viaje"];

        $horita=date('Y-m-d H:i:s');
     
        $this->ChoferModel->informarPosicion($id_viaje,$latitud_actual, $longitud_actual,$horita);
        header("location: /chofer");

    }

    public function finalizarViaje(){
        $cantidadDeCombustible= $_POST["cantidadDeCombustible"];
        $promedioPrecioCombustible= $_POST["promedioPrecioCombustible"];
        $totalPeaje= $_POST["totalPeaje"];
        $totalViaticos= $_POST["totalViaticos"];
        $totalExtras= $_POST["totalExtras"];
        $totalCombustible= $_POST["totalCombustible"];
        $id_viaje= $_POST["id_viaje"];

        $this->ChoferModel->finalizarViaje($cantidadDeCombustible,$promedioPrecioCombustible, $totalPeaje,$totalViaticos,$totalExtras,$totalCombustible,$id_viaje);
        header("location: /chofer");
    }

}