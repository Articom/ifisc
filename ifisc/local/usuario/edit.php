<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//comprobamos si los datos que se desea ver es el propio o uno ajeno


if (count($_GET) > 0) {
    if ($_GET['user'] && $_GET['edit']) {
        //si tiene una propiedad user en el get
        //significa que quiere ver un perfil ajeno
        $clase_datos_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
        $clase_usuario_location = $path_absoluto ."model/class_usuario.php";
        $permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
        include $clase_usuario_location;
        include $clase_datos_usuario_location;
        require $permisos_location;
        //se hace una isntancia del objeto de usuario y datos de usuario
        $obj_datos_usuario = new datos_usuario;
        $obj_usuario = new usuarioN;
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
        $titulo = "Editar datos de ".$_GET['user'];
        if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                //comprobamos si el perfil que se quiere acceder es el pripio como parametro
                if ($datosusuario['Nombre'] === $_SESSION['logged_user']) {
                   //si el usuario loggeado es igual al perfil que se quiere ver
                    $perfilPropio = true;
                    //se comprueba si tiene el permiso para editar su perfil
                    if ($permiso_usuario['EditarMiUsuario']) {
                        //si es cierto continua...
                    }//de lo contrario vuelve al perfil
                    else{
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                        exit;
                    }
                }else{
                    //queremos editar el perfil ajeno...
                    //se compruban los permisos de los usuarios
                     if ($permiso_usuario['EditarUsuario']) {
                        //si es cierto continua...
                    }//de lo contrario vuelve al perfil
                    else{
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                        exit;
                    }
                }
            }else{
                //si no exite sesion alguna muestra la ventana de inicio de sesion
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /ifisc/local/sesion/login.php"); 
                exit;
            }
        }else{
            $show_menu = false;
        //si no exite sesion alguna muestra la ventana de inicio de sesion
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /ifisc/local/sesion/login.php"); 
        exit;
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
        include $clase_usuario_location;
        include $clase_datos_usuario_location;
         //se hace una isntancia del objeto de usuario y datos de usuario
        $obj_datos_usuario = new datos_usuario;
        $obj_usuario = new usuarioN;
        //variables que guardan los datos de usuario y el usuario
        $datosusuario = $obj_usuario->getUsuarioByName($_SESSION['logged_user']);
        $datosde_usuario = $obj_datos_usuario->getDatosDeUsuarioById($datosusuario['id']);
        //texto del titulo de la ventana
        $titulo = "Editar mis datos";
        //variable flag para indicar si el perfil es propio o no
        $perfilPropio = true;
        //se compruban los permisos
        if ($permiso_usuario['EditarMiUsuario']) {
            //si es cierto continua...
         }//de lo contrario vuelve al perfil
         else{
             header("HTTP/1.1 301 Moved Permanently");
             header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
             exit;
        }
    
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
$roles_location = $path_absoluto ."model/common/load_all_role.php";
$carreras_location = $path_absoluto ."model/common/load_all_carreras.php";
$header_location = $path_absoluto ."local/_header.php";
//se renderiza el html de la cabecera

include $header_location; 
include_once $roles_location;
include_once $carreras_location;
?>
<!-- contenido de la pagina -->
<?php 
//comprobamos que datos desea editar... si los basicos o los detallados
if ($_GET['edit']==='1') {
    //se van a editar los datos basicos
    //si ha ocurrido un error se muestra en esta area
    echo '<div id = "errorRed">';
    ////////////////errores/////////////////////
    if (isset($_GET['error'])) {
        //si el error es de tipo de validacion de contraseña
        if ($_GET['error']==='pass1') {
            //las contraseñas introducidas no coinciden
            echo '<h6>';
            echo 'Contraseña erronea.';
            echo '</h6>';
        }elseif ($_GET['error']==='pass2') {
            //La repeticion de la contraseña no coincide
            echo '<h6>';
            echo 'Las contraseñas no coinciden.';
            echo '</h6>';
        }elseif ($_GET['error']==='mail') {
            //El correo esta siendo utilizado por otra persona
            echo '<h6>';
            echo 'Este correo esta siendo utilizado por otra persona.';
            echo '</h6>';
        }elseif ($_GET['error']==='ced') {
            //El correo esta siendo utilizado por otra persona
            echo '<h6>';
            echo 'Esta cédula le pertenece ya a otra persona.';
            echo '</h6>';
        }elseif ($_GET['error']==='userName') {
            //El nombre de usuario esta siendo utilizado por otra persona
            echo '<h6>';
            echo 'Este nombre de usuario esta siendo utilizado por otra persona.';
            echo '</h6>';
        }
    }
    echo "</div>";
    /////////////////////////////////////////////
     echo '<form id="edit-user" data-ajax="false" action="/ifisc/model/admin/usuario/update_user.php?edit=';
   echo $_GET['edit']."&&user=".$datosusuario['Nombre'];
    echo '" method="POST" >';
    /////////////////////////////////////////////////////////////////
    ////////////////////////FORMULARIO////////////////////////////////
    //////////////////////////////////////////////////////////////////
             echo ' <div data-role="fieldcontain" class="text-box">
                        <label for="textinput1">
                            Nombre o NICK
                        </label>
                        <input name="nickName" id="textinput1" placeholder="" value="';
                        echo $datosusuario['Nombre'];
                        echo '" type="text" ';
                        //si el usuario posee permisos para editar el nick de los usuarios
                         if ($permiso_usuario['CambiarNICK']) {
                            echo '/></div>';
                         }else{
                            //si no tiene el permiso se le muestra como solo lectura
                            echo 'readonly/></div>';
                         }
               ////////////
                        if ($perfilPropio) {
                           //si estamos editando nuestro propio perfil
                            //permitimos hacer un cambio de contraseña
                       echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput5">
                                     Contaseña actual
                                </label>
                                <input name="old-password" id="textinput5" placeholder="" value="" type="password" />
                            </div>
                            <div data-role="fieldcontain" class="text-box">
                                <label for="textinput5">
                                    Contaseña nueva
                                </label>
                                <input name="new-password" id="textinput5" placeholder="" value="" type="password" />
                            </div>
                            <div data-role="fieldcontain" class="text-box">
                                <label for="textinput4">
                                    Repita la contaseña nueva
                                </label>
                            <input name="re-password" id="textinput4" placeholder="" value="" type="password" />
                            </div>';
                        }
                        //si no estamos editando el propío y tenemos los permisos para resetar el password
                        elseif ($permiso_usuario['ResetearPassword']) {
                           
                           echo '<div data-role="fieldcontain" class="text-box">
                                    <label for="textinput5">
                                        Nueva Contaseña
                                    </label>
                                    <input name="new-password" id="textinput5" placeholder="" value="';
                                    echo substr(md5(rand()), 0, 7);
                                    echo '"  type="text" />
                                </div>';
                                echo '  <input type="submit" name="submit"'; 
                                echo' data-mini="true" data-inline="true" data-theme="a" value="Resetear contraseña" class="acep-button" />';
                        }
                ///////////////////
                        echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Cédula
                                </label>
                                <input name="cedula" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['Cedula'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                            echo '<div id="sex-button" data-role="fieldcontain">
                                    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                                        <legend>
                                            Género
                                        </legend>
                                        <input id="radio1" name="sex" value="mas" type="radio">
                                        <label for="radio1">
                                            Masculino
                                        </label>
                                        <input id="radio3" name="sex" value="fem" type="radio">
                                        <label for="radio3">
                                            Femenino
                                        </label>
                                    </fieldset>
                                </div>';
                /////////////////
                            echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    E-Mail
                                </label>
                                <input name="correo" id="textinput9" placeholder="" value="';
                                 echo $datosusuario['mail'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                            //comprobamos si el usuario en cuestion tiene privilegios para 
                            //cambiar los roles de los usuarios
                            if ($permiso_usuario['CambiarRol']){
                               echo '<div data-role="fieldcontain">
                                        <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                                              <legend>
                                                  Funci&oacute;n dentro de la UTP
                                              </legend>';
                                 $indice = 1;
                               while($row1 = mysql_fetch_array($roles)){
                               echo '<input id="radio'.$indice;
                               echo '" name="rol" value="';
                               echo $row1['id'];//el id del objeto
                               echo '" type="radio" data-theme="a"/>';
                               echo '<label for="radio'.$indice;
                               echo '">';
                               echo $row1['Nombre'];//nombre del objeto
                               echo '</label>';
                               $indice++;
                           } 
                        echo '</fieldset></div>';
                            }
                    //////////////////////
                            //estos datos solo se mostrarán si el usuario es de tipo estudiante
                            if ($datosusuario['id_role']==='3') {
                                 echo   '<div data-role="fieldcontain">
                                     <fieldset data-role="controlgroup" data-type="vertical" data-mini="true">
                                        <legend>
                                             Carrera
                                         </legend>';
                                $indice = 1;
                                while($row = mysql_fetch_array($carreras)){
                                   echo '<input id="radio'.$indice;
                                   echo '" name="carrera" value="';
                                   echo $row['id'];//el id del objeto
                                   echo '" type="radio" data-theme="a"/>';
                                   echo '<label for="radio'.$indice;
                                   echo '">';
                                   echo $row['Nombre'];//nombre del objeto
                                   echo '</label>';
                                   $indice++;
                                } 
                                echo  '</fieldset></div>';  
                            }  
                ///////////////////////////////////////////                       
                       echo '<div data-role="fieldcontain">
                                <label for="feed">
                                    Recibir notificaciones al correo
                                </label>
                                <select name="feed" id="feed" data-theme="a" data-role="slider"
                                data-mini="true">
                                    <option value="off" ';
                                    if (!$datosusuario['Feed']) {
                                        echo 'Selected';
                                    }
                                    echo '>
                                        No
                                    </option>
                                    <option value="on"';
                                    if ($datosusuario['Feed']) {
                                        echo 'Selected';
                                    }
                                    echo '>
                                        Si
                                    </option>
                                </select>
                            </div>';
    //////////////////////////////////////////////////////////////////////
            echo '  <input type="submit" name="submit" data-mini="true" data-inline="true" data-theme="a" value="Guardar Datos" class="acep-button" />
                </form>';
}
elseif ($_GET['edit']==='2') {
   //se van a editar los datos detallados
 //se van a editar los datos basicos
    echo '<form id="edit-user" data-ajax="false" action="/ifisc/model/admin/usuario/update_user.php?edit=';
    echo $_GET['edit']."&&user=".$datosusuario['Nombre'];
    echo '" method="POST" >';
    /////////////////////////////////////////////////////////////////
    ////////////////////////FORMULARIO////////////////////////////////
    //////////////////////////////////////////////////////////////////
             
                        echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Primer Nombre
                                </label>
                                <input name="name1" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['Nombre1'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                             echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Segundo Nombre
                                </label>
                                <input name="name2" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['Nombre2'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                             echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Apellido
                                </label>
                                <input name="apellido1" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['Apellido1'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                             echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Apellido Materno
                                </label>
                                <input name="apellido2" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['Apellido2'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                             echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Fecha de Nacimiento
                                </label>
                                <input name="fechaNac" type="date" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['FechaNac'];
                                echo '" type="text" />
                            </div>';
                /////////////////
                             echo '<div data-role="fieldcontain" class="text-box">
                                <label for="textinput9">
                                    Fecha de Matricula en la UTP
                                </label>
                                <input name="fechaMatr" type="date" id="textinput9" placeholder="" value="';
                                 echo $datosde_usuario['FechaMatr'];
                                echo '" type="text" />
                            </div>';
               
    //////////////////////////////////////////////////////////////////////
            echo '  <input type="submit" name="submit" data-mini="true" data-inline="true" data-theme="a" value="Guardar Datos" class="acep-button" />
                </form>';
}
//si la operacion no es ni 1 ni 2
else{
    //se muestra el error de operacion desconocida
                    //Se proporciona un link para retornar al inicio
                    echo ' <div id = "errorRed">';
                    echo '<h6>';
                    echo 'Operación de edicion inválida.';
                    echo '</h6>';
                     echo '<a href="/ifisc/index.php" data-ajax="false" data-transition="fade" class="enlace">
                                Volver al Inicio
                            </a>';
                    echo '</div>';
}
?>
 

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
