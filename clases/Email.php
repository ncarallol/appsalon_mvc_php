<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;
    public $apellido;

    public function __construct($email, $nombre, $apellido, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->token = $token;
    }

public function enviarRecuperar() {

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['EMAIL_PORT'];
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];

    $mail->setFrom('appsalon@correo.com');
    $mail->addAddress('appsalon@correo.com', 'appsalon');  

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';                                
    $mail->Subject = 'Recupera tu contraseña';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . " </strong>Bienvenido a Appsalon, recupera tu contraseña haciendo click en el siguiente enlace</p>";
    $contenido .= "<a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Recuperar Contraseña</a>";
    $contenido .= "<p>Si tu no solicitaste esta recuperacion, ignora este mensaje</p>";
    $contenido .= "</html>";

    
    $mail->Body    = $contenido;
    $mail->send();
    
    
}
public function enviarConfirmacion() {

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $_ENV['EMAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['EMAIL_PORT'];
    $mail->Username = $_ENV['EMAIL_USER'];
    $mail->Password = $_ENV['EMAIL_PASS'];

    $mail->setFrom('appsalon@correo.com');
    $mail->addAddress('appsalon@correo.com', 'appsalon');  

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';                                
    $mail->Subject = 'Confirma tu cuenta';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " . $this->nombre . " " . $this->apellido . "</strong>Bienvenido a Appsalon, confirma tu cuenta haciendo click en el siguiente enlace</p>";
    $contenido .= "<a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";
    $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora este mensaje</p>";
    $contenido .= "</html>";

    
    $mail->Body    = $contenido;
    $mail->send();
    
    
}
}