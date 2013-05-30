<!-- *********************confirmacion************************ -->
<?php 
$host_name=$_SERVER['HTTP_HOST'];
$mensaje = '<h1><strong>&iexcl;Felicidades '.$nombre.', ya casi completas tu registro en iFISC!</strong></h1>
<p style="text-align: justify;">Gracias por haber completado la primera etapa del registro, no podemos esperar para enviarte actualizaciones de las &uacute;ltimas noticias y eventos que suceden en la Facultad de Ingenier&iacute;a en Sistemas.</p>
<p style="text-align: justify;">Para completar la &uacute;ltima etapa del registro comprueba que tus datos de registro son correctos:</p>
<ul style="list-style-type: disc;">
<li><strong>Nombre de usuario</strong>: '.$nombre.'</li>
<li><strong>Contrase&ntilde;a</strong>: '.$pass.'</li>
<li><strong>C&oacute;digo de activaci&oacute;n</strong>: '.$codigo.'</li>
</ul>
<p>A continuaci&oacute;n pincha sobre el siguiente enlace, antes de 7 d&iacute;as, para activar tu cuenta:</p>
<ul style="list-style-type: square;">
<li>Ingresa aqu&iacute; : <a href="'.$host_name.'/ifisc/model/admin/usuario/aprobar_usuario.php?cod='.$codigo.'&&usr='.$nombre.'&& target="_blank">Confirma tu cuenta</a></li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Enviado el :&nbsp;'.date("Y-m-d H:i:s").'.</p>
<h5>RobotiFISC&nbsp;<strong><span class="tag">&lt;3</span></strong></h5>
<p>&nbsp;</p>
<p>&nbsp;</p>';

$altMensaje = '¡Felicidades '.$nombre.', ya casi completas tu registro en iFISC!

Gracias por haber completado la primera etapa del registro, no podemos esperar para enviarte actualizaciones de las últimas noticias y eventos que suceden en la Facultad de Ingeniería en Sistemas.

Para completar la última etapa del registro comprueba que tus datos de registro son correctos:

-Nombre de usuario: '.$nombre.'
-Contraseña: '.$pass.'
-Código de activación: '.$codigo.' 
A continuación pincha sobre el siguiente enlace, antes de 7 días, para activar tu cuenta:

Ingresa aquí : '.$host_name.'/ifisc/model/admin/usuario/aprobar_usuario.php?cod='.$codigo.'&&usr='.$nombre.'
 

Enviado el : '.date("Y-m-d H:i:s").'.

RobotiFISC <3';


 ?>
