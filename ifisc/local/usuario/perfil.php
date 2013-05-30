<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//comprobamos si el perfil que se desea ver es el propio o uno ajeno
if (count($_GET) > 0) {
    if ($_GET['user']) {
        //si tiene una propiedad user en el get
        //significa que quiere ver un perfil ajeno
        $clase_datos_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
        $clase_usuario_location = $path_absoluto ."model/class_usuario.php";
        $clase_carrera_location = $path_absoluto ."model/class_carrera.php";
        $clase_role_location = $path_absoluto ."model/class_role.php";
        include $clase_usuario_location;
        include $clase_datos_usuario_location;
        include $clase_carrera_location;
        include $clase_role_location;
        //se hace una isntancia del objeto de usuario y datos de usuario
        $obj_datos_usuario = new datos_usuario;
        $obj_usuario = new usuarioN;
        $obj_role = new role;
        $perfilPropio = false;
        //variables que guardan los datos de usuario y el usuario
        $datosusuario = $obj_usuario->getUsuarioByName($_GET['user']);
        if (!$datosusuario['id']) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
        exit;
        }
        $datosde_usuario = $obj_datos_usuario->getDatosDeUsuarioById($datosusuario['id']);
        //texto del titulo de la ventana
        $titulo = "Perfil de ".$_GET['user'];
        if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                //comprobamos si el perfil que se quiere acceder es el pripio como parametro
                if ($_GET['user'] === $_SESSION['logged_user']) {
                   //si el usuario loggeado es igual al perfil que se quiere ver
                    $perfilPropio = true;
                    $titulo = "Mi perfil";
                }
            }
        }else{
            $show_menu = false;
        }
       
    }else{
        header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
        exit;
    }
}
//si, no se muestra el propio
//se comprueba, antes que todo, si el usuario esta logeado
elseif (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        //si esta logeado
         $clase_datos_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
        $clase_usuario_location = $path_absoluto ."model/class_usuario.php";
        $clase_carrera_location = $path_absoluto ."model/class_carrera.php";
        $clase_role_location = $path_absoluto ."model/class_role.php";
        include $clase_usuario_location;
        include $clase_datos_usuario_location;
        include $clase_carrera_location;
        include $clase_role_location;
        //se hace una isntancia del objeto de usuario y datos de usuario
        $obj_datos_usuario = new datos_usuario;
        $obj_usuario = new usuarioN;
        $obj_role = new role;
        //variables que guardan los datos de usuario y el usuario
        $datosusuario = $obj_usuario->getUsuarioByName($_SESSION['logged_user']);
        $datosde_usuario = $obj_datos_usuario->getDatosDeUsuarioById($datosusuario['id']);
        //texto del titulo de la ventana
        $titulo = "Mi perfil";
        //variable flag para indicar si el perfil es propio o no
        $perfilPropio = true;
        //si la pagina es privada requiere un menú 
        $show_menu = true;

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

//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
     <ul data-role="listview" data-divider-theme="a" data-inset="true">
        <li data-role="list-divider" role="heading">
            Datos básicos
        </li>
        <li>
        <div data-role="fieldcontain">
            <?php 
            echo '<label for="textarea1">
                    <strong>Nombre de usuario:</strong>
                  </label>';
            echo '<input type="text" id="textarea1" name="nickname" readonly value="';
            echo $datosusuario['Nombre'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain">
            <?php 
            echo '<label for="textarea2">
                    <strong>Cédula:</strong>
                  </label>';
            echo '<input type="text" id="textarea2" readonly value="';
            echo $datosde_usuario['Cedula'];
            echo '">';
            ?>
        </div>
            <?php 
            //si es un usuario con rol de estudiante se muestran los datos de la carrera
            if ($datosusuario['id_role']==='3') {
                echo '<div data-role="fieldcontain">';
                echo '<label for="textarea2">
                        <strong>Carrera:</strong>
                        </label>';
                echo '<input type="text" readonly value="';
                $obj_carrera_name = new carrera;
                if ($datosde_usuario['id_carrera']) {
                    //si tiene datos de carrera
            
                    echo $obj_carrera_name->getCarreraNameById($datosde_usuario['id_carrera']);
                }
                echo '">';
                echo "</div>";
            }
            
            ?>
        
        <div data-role="fieldcontain">
            <?php 
            echo '<label for="textarea2">
                    <strong>Género:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            if ($datosde_usuario['esHombre']) {
             echo 'Masculino';   
            }else{
                echo 'Femenino';
            }
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain">
            <?php 
            echo '<label for="textarea2">
                    <strong>E-Mail:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosusuario['mail'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain">
            <?php 
            echo '<label for="textarea2">
                    <strong>Rol:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
           echo $obj_role->getNombreRoleById($datosusuario['id_role']); 
            echo '">';
            ?>
        </div>
         <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>En iFISC desde:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['FechaInscrip'];
            echo '">';
            ?>
        </div>
        <?php 
        //verificamos primeramente si el usuario esta loggeado
         if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado verificamos los permisos pertinentes
                 $permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
                //se carga el archivo que realiza la consulta y extrae los permisos
                require $permisos_location;
               //verificamos el permiso
                //si el perfil al que se desea acceder es propio
                if ($perfilPropio) {
                    //verificamos si tiene el permiso de editar su usuario
                    if ($permiso_usuario['EditarMiUsuario']) {
                       //si tiene el permiso se le muestra el boton
                         echo  '<div data-role="content"><a href="/ifisc/local/usuario/edit.php?edit=1&&user=';
                        //el nombre del usuario al que se va a editar
                        echo $datosusuario['Nombre'];
                        echo '" name="edit2" data-inline="true"
                                data-ajax="false"
                                data-theme="a" data-icon="edit" data-iconpos="left"
                                data-mini="true" data-role="button" >
                                Editar datos
                                </a></div>';
    
                    }
                }else{
                    //si el perfil que va a ver no es el propio
                    //verificamos el permiso para modificar perfiles ajenos
                     if ($permiso_usuario['EditarUsuario']) {
                       //si tiene el permiso se le muestra el boton
                        echo  '<div data-role="content"><a href="/ifisc/local/usuario/edit.php?edit=1&&user=';
                        //el nombre del usuario al que se va a editar
                        echo  $datosusuario['Nombre'];
                        echo '" name="edit2" data-inline="true"
                                data-ajax="false"
                                data-theme="a" data-icon="edit" data-iconpos="left"
                                data-mini="true" data-role="button" >
                                Editar datos
                                </a></div>';
    
                    }
                }
            }
        }

         ?>
     </li>
</ul>
<ul data-role="listview" data-divider-theme="a" data-inset="true">
        <li data-role="list-divider" role="heading">
            Datos detallados
        </li>
        <li>
        <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>Primer Nombre:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['Nombre1'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>Segundo Nombre:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['Nombre2'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain" class="text-box">
            <?php
            echo '<label for="textarea2">
                    <strong>Apellido:</strong>
                  </label>'; 
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['Apellido1'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>Apellido Materno:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['Apellido2'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>Fecha de Nacimiento:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['FechaNac'];
            echo '">';
            ?>
        </div>
        <div data-role="fieldcontain" class="text-box">
            <?php 
            echo '<label for="textarea2">
                    <strong>Fecha de Matrícula:</strong>
                  </label>';
            echo '<input type="text" readonly value="';
            echo $datosde_usuario['FechaMatr'];
            echo '">';
            ?>
        </div>
        <?php 
        //verificamos primeramente si el usuario esta loggeado
         if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
            if ($perfilPropio) {
                    //verificamos si tiene el permiso de editar su usuario
                    if ($permiso_usuario['EditarMiUsuario']) {
                       //si tiene el permiso se le muestra el boton
                        echo  '<div data-role="content"><a href="/ifisc/local/usuario/edit.php?edit=2&&user=';
                        //el nombre del usuario al que se va a editar
                        echo $datosusuario['Nombre'];
                        echo '" name="edit2" data-inline="true"
                                data-ajax="false"
                                data-theme="a" data-icon="edit" data-iconpos="left"
                                data-mini="true" data-role="button" >
                                Editar datos
                                </a></div>';
                    }
                }else{
                    //si el perfil que va a ver no es el propio
                    //verificamos el permiso para modificar perfiles ajenos
                     if ($permiso_usuario['EditarUsuario']) {
                       //si tiene el permiso se le muestra el boton
                        echo  '<div data-role="content"><a href="/ifisc/local/usuario/edit.php?edit=2&&user=';
                        //el nombre del usuario al que se va a editar
                        echo $datosusuario['Nombre'];
                        echo '" name="edit2" data-inline="true"
                                data-ajax="false"
                                data-theme="a" data-icon="edit" data-iconpos="left"
                                data-mini="true" data-role="button" >
                                Editar datos
                                </a></div>';
    
                    }
                }
            }
        }
         ?>
    </li>
    
</ul>

<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
