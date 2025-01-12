<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
     
        $mail->setFrom('cuentas@devwebcamp.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu Cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<body style='font-family: Arial, sans-serif; background-color: #F8FAFC; color: #1a1b15; padding: 20px;'>";
        $contenido .= "<div style='max-width: 600px; margin: auto; background-color: #FFFFFF; padding: 20px; border-radius: 8px;'>";
        $contenido .= "<h1 style='color: #007df4; text-align: center;'>¡Confirma tu Cuenta!</h1>";
        $contenido .= "<p style='font-size: 16px; color: #1a1b15;'>Hola <strong style='color: #007df4;'>" . $this->nombre . "</strong>,</p>";
        $contenido .= "<p style='font-size: 16px; color: #64748B;'>Has registrado correctamente tu cuenta en DevWebCamp, pero es necesario confirmarla para completar el proceso.</p>";
        $contenido .= "<p style='text-align: center; margin: 20px 0;'>";
        $contenido .= "<a href='" . $_ENV['HOST'] . "/confirmar-cuenta?token=" . $this->token . "' style='display: inline-block; padding: 10px 20px; background-color: #00c8c2; color: #FFFFFF; text-decoration: none; border-radius: 5px; font-size: 16px;'>Confirmar Cuenta</a>";
        $contenido .= "</p>";
        $contenido .= "<p style='font-size: 14px; color: #64748B;'>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= "</div>";
        $contenido .= "<footer style='text-align: center; margin-top: 20px; font-size: 12px; color: #1E293B;'>DevWebCamp - Todos los derechos reservados.</footer>";
        $contenido .= "</body>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('cuentas@devwebcamp.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<body style='font-family: Arial, sans-serif; background-color: #F8FAFC; color: #1a1b15; padding: 20px;'>";
        $contenido .= "<div style='max-width: 600px; margin: auto; background-color: #FFFFFF; padding: 20px; border-radius: 8px;'>";
        $contenido .= "<h1 style='color: #007df4; text-align: center;'>Reestablece tu Password</h1>";
        $contenido .= "<p style='font-size: 16px; color: #1a1b15;'>Hola <strong style='color: #007df4;'>" . $this->nombre . "</strong>,</p>";
        $contenido .= "<p style='font-size: 16px; color: #64748B;'>Has solicitado reestablecer tu password. Sigue el enlace a continuación para hacerlo:</p>";
        $contenido .= "<p style='text-align: center; margin: 20px 0;'>";
        $contenido .= "<a href='" . $_ENV['HOST'] . "/reestablecer?token=" . $this->token . "' style='display: inline-block; padding: 10px 20px; background-color: #00c8c2; color: #FFFFFF; text-decoration: none; border-radius: 5px; font-size: 16px;'>Reestablecer Password</a>";
        $contenido .= "</p>";
        $contenido .= "<p style='font-size: 14px; color: #64748B;'>Si tú no solicitaste este cambio, puedes ignorar este mensaje.</p>";
        $contenido .= "</div>";
        $contenido .= "<footer style='text-align: center; margin-top: 20px; font-size: 12px; color: #1E293B;'>DevWebCamp - Todos los derechos reservados.</footer>";
        $contenido .= "</body>";
        $contenido .= '</html>';
        $mail->Body = $contenido;


        //Enviar el mail
        $mail->send();
    }
}