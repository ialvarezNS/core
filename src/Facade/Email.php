<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



/**
 * Clase para el envio de mail
 */
class EmailFacade
{
    protected static $mailer;

    /**
     * Method to setup Mailer intance
     * @param mixed $host 
     * @param mixed $username
     * @param mixed $password
     * @param mixed $smtpSecure
     * @param mixed $port
     */

    public static function getMailer($host,$username,$password,$smtpSecure = "PHPMailer::ENCRYPTION_STARTTLS",$port = 587)
    {
        if (!self::$mailer) {
            self::$mailer = new PHPMailer(true);
           
            self::$mailer->isSMTP();
            self::$mailer->Host = $host;
            self::$mailer->SMTPAuth = true;
            self::$mailer->Username = $username;
            self::$mailer->Password = $password;
            self::$mailer->SMTPSecure = $smtpSecure;
            self::$mailer->Port = $port;
        }

        return self::$mailer;
    }

    /**
     * Method to send mail 
     *
     * @param [string] $to
     * @param [string] $subject
     * @param [string] $body
     * @param string $from
     * @param string $fromName
     * @return void
     */
    public static function send($to, $subject, $body, $from = 'noreply@example.com', $fromName = 'Sender Name')
    {
        try {
            $mailer = self::getMailer();
            $mailer->setFrom($from, $fromName);
            $mailer->addAddress($to);
            $mailer->Subject = $subject;
            $mailer->Body = $body;

            
            $result = $mailer->send();

            return $result; 
        } catch (Exception $e) {
           
            echo "Error al enviar el correo: {$mailer->ErrorInfo}";
            return false;
        }
    }
}