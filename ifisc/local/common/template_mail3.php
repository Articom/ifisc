
<?php 
$host_name=$_SERVER['HTTP_HOST'];
$mensaje = '
<h1 style="text-align: center;"><strong>Nueva Publicaci&oacute;n en iFISC</strong></h1>
<hr />
<h2><a href="'.$host_name.'/ifisc/local/vistas/vmart.php?art='.$publicacion_id.'">&nbsp;<strong>'.$publication['Titulo'].'</strong></a></h2>
<h5><span style="text-decoration: underline;">Publicada por:<a href="'.$host_name.'/ifisc/local/usuario/perfil.php?user='.$nombre_publicador['Nombre'].'">'.$nombre_publicador['Nombre'].'</a></span></h5>
<div style="text-align: justify;">'.substr(strip_tags($publication['Cuerpo']),0,250).'...'.'</div>
<hr/>
<h6>Estas subscipto a las actualizaciones de email de iFISC.</h6>
<h6>Si deseas dejar de recibir estos correos cancela la subscripci&oacute;n.</h6>';
// echo $mensaje;

$altMensaje = 'Nueva Publicación en iFISC

'.$host_name.'/ifisc/local/vistas/vmart.php?art='.$publicacion_id.'
'.$publication['Titulo'].'

Publicada por:'.$nombre_publicador['Nombre'].'
'.$host_name.'/ifisc/local/usuario/perfil.php?user='.$nombre_publicador['Nombre'].'
'.substr(strip_tags($publication['Cuerpo']),0,250).'



Estas subscipto a las actualizaciones de email de iFISC.
Si deseas dejar de recibir estos correos cancela la subscripción.';