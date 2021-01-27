<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//you need compser
require 'vendor/autoload.php';

function SendMail($mail_address,$message_text){
	
$mail = new PHPMailer(true);   
try {
    // Paremetrs SMTP-server
    //$mail->SMTPDebug = 2;                                 
    $mail->isSMTP();                                        
    $mail->Host = 'smtp.gmail.com';                        
    $mail->SMTPAuth = true;                                 
    $mail->Username = 'SENDER LOGIN GMAIL';                   
    $mail->Password = 'SENDER PASSWORD GMAIL';
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;                                     

    // Получатели
    $mail->setFrom('RECIPIENT  ANY MAIL', 'Robot');        
    $mail->addAddress($mail_address);     /
    //$mail->addAddress('contact@example.com');            
    //$mail->addReplyTo('info@example.com', 'Info');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attach files
    //$mail->addAttachment('/var/tmp/file.tar.gz');         
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    

    // Контент письма
    $mail->CharSet = 'UTF-8';                               
    $mail->isHTML(true);                                    
    $mail->Subject = 'Subject mail';
    $mail->Body    = $message_text;



    $mail->send();
    echo 'Mail was sent';

} catch (Exception $e) {
    echo 'Sending error.';
    echo 'Eroor: ' . $mail->ErrorInfo;
	}
}

require_once('../app/controllers/ApiController.php');
ToFirebaseSend_Notif();

SendMail("SUBJECT MAIL",'TEXT MAIL');



?>