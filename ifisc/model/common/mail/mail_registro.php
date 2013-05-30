
<?php
//busca la ubicacion del archivo 
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

 $destino = $_GET['correo'];
 $nombre = $_GET['nombre'];
 if (isset($_GET['cod'])) {
   $codigo =$_GET['cod'];
 }
 
 $tipo = $_GET['tipo'];

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
$mail->AddReplyTo($destino, $nombre);
//Set who the message is to be sent to
$mail->AddAddress($destino, $nombre);
//Set the subject line
$host_name=$_SERVER['HTTP_HOST'];
if ($tipo === "etapa1") {  
   $pass = $_GET['pass'];
  $mail->Subject = 'Confirmación de correo electrónico';
  //se importa el archivo de el mensaje correspondiente
  $template = $path_absoluto ."local/common/template_mail1.php";
  require $template;

  $mail->Body     = $mensaje;
  $mail->AltBody = $altMensaje;
}
elseif ($tipo === "etapa2") {
  $mail->Subject = 'Registro completo';
  //se importa el archivo del mensaje correspondiente
  $template = $path_absoluto ."local/common/template_mail2.php";
  require $template;

  $mail->Body     = $mensaje;
  $mail->AltBody = $altMensaje;
}

if(!$mail->Send()) {

  //mostrar el error de que el correo de registro ha fallado
  //que indique estos datos al administrador del sistema
         
} else {
  if ($tipo === "etapa2") {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/sesion/login.php?exito=1"); 
            exit;
        }else{
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/sesion/login.php"); 
            exit;
        }
}

?>