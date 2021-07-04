<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpMailer/Exception.php';
require './phpMailer/PHPMailer.php';
require './phpMailer/SMTP.php';

class registroController
{
    private $registroModel;
    private $render;

    public function __construct($registroModel, $render)
    {
        $this->registroModel = $registroModel;
        $this->render = $render;
    }

    public function execute()
    {
        if (isset($_GET["mensaje"])) {

            $mensaje["mensaje"] = $_GET["mensaje"];
            echo $this->render->render("view/registro.mustache", $mensaje);
        } else {
            echo $this->render->render("view/registro.mustache");

        }
    }

    public function enviarMailConfirmacion($email, $nombre, $apellido)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'programacionweb2tpfinal@gmail.com';                     //SMTP username
            $mail->Password = 'web2tpfinal';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('programacionweb2tpfinal@gmail.com', 'Administrador');
            $mail->addAddress("$email");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Confirmar registro';
            $mail->Body = 'Hola, ' . $nombre . $apellido . ' "Haga click aquí para confirmar su registro a nuestra plataforma! <br><br><button>Confirmar</button>';

            $mail->send();
            header("location: ../login?mensaje=registrado");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function registrarUsuario()
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $legajo = $_POST["legajo"];
        $dni = $_POST["dni"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $tipo_licencia = $_POST["tipo_licencia"];
        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];


        if (!$this->registroModel->getValidarRegistro($dni, $legajo, $email)) {
            $this->registroModel->registrarUsuario($nombre, $apellido, $legajo, $dni, $fecha_nacimiento, $tipo_licencia, $email, $contraseña);
            $this->enviarMailConfirmacion($email, $nombre, $apellido);
        } else {

            header("location: ../registro?mensaje=yaExiste");

        }
    }


}

?>