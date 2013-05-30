<?php 
	//menú dinámico según el rol del usuario

//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 
//se comprueba, antes que todo, si el usuario esta logeado
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
    	$conection_location = $path_absoluto ."model/sesion/seguridad/open_conn.php";
		require $conection_location;
        //si esta logeado
        $permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
        //se carga el archivo que realiza la consulta y extrae los permisos
        require $permisos_location;
    }else{
        //si no exite sesion alguna muestra la ventana de inicio de sesion
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /ifisc/local/sesion/login.php"); 
        exit;
    }
}else{
        //si no exite sesion alguna muestra la ventana de inicio de sesion
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /ifisc/local/sesion/login.php"); 
        exit;
}  
 ?>
<!-- menu-->
<!-- abrr un link sin ajax y con transisision
<a href="../index.html" data-icon="grid" 
class="ui-btn-right" rel="external">Home</a> -->
<div data-role="panel" data-position-fixed="true" data-theme="a" id="nav-panel">
        <ul data-role="listview" data-theme="a" class="nav-search">
            <li data-icon="delete"><a href="#" data-rel="close">Cerrar menú</a></li>		
					<li data-role="list-divider"></li>
						<li class="active"><a href="/ifisc/index.php" data-transition="fade" rel="external" class="contentLink">Inicio</a></li>
						<li class="active"><a href="/ifisc/local/usuario/perfil.php" data-transition="fade" rel="external" class="contentLink">Perfil</a></li>
						<li class="active"><a href="/ifisc/local/usuario/preferencias.php" data-transition="fade" rel="external" class="contentLink">Mis preferencias</a></li>
						
					<li data-role="list-divider">Publicaciones</li>
										
					<h3>Intereses</h3>
					<ul>
					<li><a href="#home" class="contentLink">Ayuda</a></li>
					<!--li><a href="#home" class="contentLink">Configuración</a></li-->
					<li><a href="#home" class="contentLink">Condiciones y poíticas</a></li>
					<li><a href="#home" class="contentLink">Reportar Problema</a></li>
					<li><a href="/ifisc/model/sesion/salir.php" rel="external" data-transition="fade" class="contentLink">Salir</a></li>
					<h3 style=" text-align:center" ><strong>iFISC © 2013</strong></h3>	
					</ul>
    </div>