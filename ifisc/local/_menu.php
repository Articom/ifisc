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
		<div data-role="navbar" data-iconpos="right">
          		 
                   			 <a href="#">
                       			 Notificaciones
                   			 </a>
               			 
        		</div>

		<div id="menu" style="display: none;">
					
					<ul>
					<div data-role="content">

						<div data-role="fieldcontain">
						<input name="" id="searchinput2" data-icon="search" placeholder="Buscar..." value="" type="search"
						data-mini="true">
					</div>
					</div>
					</ul>
					<ul>

				
						<li class="active"><a href="/ifisc/index.php" data-transition="fade" rel="external" class="contentLink">Inicio</a></li>
						<li class="active"><a href="/ifisc/local/usuario/perfil.php" data-transition="fade" rel="external" class="contentLink">Perfil</a></li>
						<li class="active"><a href="/ifisc/local/usuario/preferencias.php" data-transition="fade" rel="external" class="contentLink">Mis preferencias</a></li>
						
					</ul>
					<h3>Publicaciones</h3>
					<ul>
					<?php 
						//si tiene permisos de hacer publicaciones se le muestra el menu
						if ($permiso_usuario['CrearPublicaciones']) {
							echo '<li class="active"><a href="/ifisc/local/articulo/propios.php" data-transition="fade" rel="external" class="contentLink">Mis publicaciones</a></li>';
                        	echo '<li class="active"><a href="/ifisc/local/articulo/nuevo_tipo.php" data-transition="fade" rel="external" class="contentLink">Nueva publicación</a></li>';
                    	}
                    	//si tiene permisos de aprobar publicaciones se le muestra este menú
                    	if ($permiso_usuario['AprobarPublicaciones']) {
							echo '<li class="active"><a href="/ifisc/local/articulo/aprobar.php" data-transition="fade" rel="external" class="contentLink">Aprobar publicaciones</a></li>';                		
                    	}
						 ?>
					<li><a href="/ifisc/local/articulo/categorias.php" data-transition="fade" rel="external" class="contentLink">categorias</a></li>
					</ul>
					<?php 
					//menu especial que solo se le mostrará a un usuario con rol 1 = coordinador
					if ($role_usuario['id'] === '1') {
						echo '<h3>Administración</h3><ul>';
						//menu especial para los usuarios que tengan el permiso de aprobar usuarios
						if ($permiso_usuario['AprobarUsuario']) {
							echo '<li><a href="/ifisc/local/admin/usuario/aprobar.php" data-transition="fade" rel="external">Aprobar usuarios</a></li>';
						}
						//item especial que solo se le muestra a usuarios con el permiso de editar permisos de los roles
						if ($permiso_usuario['EditarPermisos']) {
							echo '<li><a href="/ifisc/local/admin/permisos/rolesAdmin.php" data-transition="fade" rel="external">Configurar permisos</a></li>';
						}
						echo '</ul>';
					}
					
					?>					
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