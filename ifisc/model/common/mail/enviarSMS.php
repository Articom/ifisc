
<?php

 $destino = $_POST['correo'];
 $nombre = $_POST['nombre'];
 $mensaje = $_POST['mensaje'];
 $asunto = $_POST['mensaje'];

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'class.phpmailer.php';
require 'correo_parameters.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->IsSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
  // 2 = client and server messages
  $mail->SMTPDebug  = 0;
  //Ask for HTML-friendly debug output
  $mail->Debugoutput = 'html';
  //Set the hostname of the mail server
  $mail->Host       = $host;
  //Set the SMTP port number - likely to be 25, 465 or 587
  $mail->Port       = $puerto;
  //Whether to use SMTP authentication
  $mail->SMTPAuth   = $autenticacion;
  $mail->SMTPSecure = $seguridad; 
//Username to use for SMTP authentication
$mail->Username   = $usuario;
//Password to use for SMTP authentication
$mail->Password   = $contrasenia;
//Set the hostname of the mail server
$mail->SetFrom($correo, $remitente);
//Set an alternative reply-to address
$mail->AddReplyTo($destino, $nombre);
//Set who the message is to be sent to
$mail->AddAddress($destino, $nombre);
//Set the subject line
$mail->Subject = 'Prueba';
//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
//$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body     = $mensaje;
//Replace the plain text body with one created manually
$mail->AltBody = $mensaje;
//Attach an image file

//Send the message, check for errors
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Mensaje enviado!";
}
?>