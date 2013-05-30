
<?php
//busca la ubicacion del archivo 
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 



//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
$class_php_mailer = $path_absoluto ."model/common/mail/class.phpmailer.php";
$parametros = $path_absoluto ."model/common/mail/correo_parameters.php";

require $class_php_mailer;
require $parametros;

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
//se itera sobre cada uno de los resultados para enviar el correo
    while($correo_data2 = mysql_fetch_array($correos_destino2)){
        $correos = $correo_data2['mail'];
        $nombres = $correo_data2['Nombre'];
        //se agregan los destinatarios al correo
        $mail->AddReplyTo($correos, $nombres);
        //Set who the message is to be sent to
        $mail->AddAddress($correos, $nombres);
        // echo $correos;
        // echo $nombres;
    }
//Set the subject line
$host_name=$_SERVER['HTTP_HOST'];
  $mail->Subject = 'Nueva publicación de interés';
  //se importa el archivo de el mensaje correspondiente
  $template = $path_absoluto ."local/common/template_mail3.php";
  require $template;

  $mail->Body     = $mensaje;
  $mail->AltBody = $altMensaje;
// echo 'entro'; 
if(!$mail->Send()) {
  
  //mostrar el error de que el correo de registro ha fallado
  //que indique estos datos al administrador del sistema
         
} 

?>