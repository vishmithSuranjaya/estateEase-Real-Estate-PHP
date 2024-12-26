<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//importing necessary files 
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail {
    private $senderName;
    private $senderEmail;
    private $password;
    private $SMTPhost;
    //email class constructor
    public function __construct() {
        $this->senderName = "estateEase";
        $this->senderEmail = "estateease2@gmail.com";
        $this->password = "tgwylgxcplcnxows";
        $this->SMTPhost = "smtp.gmail.com";
    }
    
    

    public function sendMail($receiver, $subject, $body) {
        $mail = new PHPMailer(true);
        
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = $this->SMTPhost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->senderEmail;
            $mail->Password = $this->password;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            

            // Sender and recipient
            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($receiver);
            $mail->addReplyTo($this->senderEmail);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body); // Plain text version

            // Send email
            $mail->send();
        } catch (Exception $e) {
           throw new Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}


?>
