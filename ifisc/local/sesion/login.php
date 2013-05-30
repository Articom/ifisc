<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Acceso a iFISC!";
$show_menu = false;
//se renderiza el html de la cabecera
//comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        //mostramos el error de que ya se ha inicado la sesion
        $show_error= true;
    }else{
        $show_error = false;
    }
}else{
    $show_error = false;
}
include $header_location; 
?>
<!-- contenido de la pagina -->
               
                 <?php 
                 if ($show_error) {
                   $usuario_name = $_SESSION['logged_user'];
                             //se muestra el mensaje de error
                        echo '<div class="bar">
                      <h1>¡Ya has iniciado sesión con este usuario:<strong> '.$usuario_name.'</strong>!</h1>';

                        echo '<h3>';
                        echo ' <a href="/ifisc/model/sesion/salir.php" data-ajax="false" data-ajax="false" data-transition="fade" class="enlace">
                           Cerrar sesión
                        </a>';
                        echo '</h3>';
                        echo '<h3>';
                        echo ' <a href="/ifisc/index.php" data-transition="fade" data-ajax="false" class="enlace">
                           Volver al inicio
                        </a>';
                        echo '</h3></div>';
                 }else{
                    //si el usuario no esta logeado...entonces
                     echo '<h2>
                                 Por favor, introduce tus datos de registro.
                          </h2>';
                    $estado ="";
                    //contamos si se ha registrado algun error
                    if (isset($_GET["error"])) {
                      echo '  <div id = "errorRed">';
                       $estado = $_GET["error"];
                         if ($estado === "err1") {
                            //si es error de tipo error de contrasenia
                            echo '<h6>';
                                 //se muestra el mensaje de error
                            echo 'Datos incorrectos, intentelo otra vez.';
                            echo '</h6>';
                             echo '     
                              <form id="form-login" data-ajax="false" action="/ifisc/model/sesion/seguridad/acceso.php" method="POST" class="mi-form">
                                  <div data-role="fieldcontain" class="input-box">
                                      <label for="textinput1">
                                          Usuario
                                      </label>
                                      <input name="usuario" id="textinput1" placeholder="" value="" type="text" />
                                  </div>
                                  <div data-role="fieldcontain">
                                      <label for="textinput2">
                                          Contraseña
                                      </label>
                                      <input name="clave" id="textinput2" placeholder="" value="" type="password" />
                                  </div>
                                  <input type="submit" data-inline="true" data-theme="b" value="Aceptar" class="acep-button" />
                                  <div>
                                      ¿Aún no estás registrado?<a href="/ifisc/local/admin/usuario/new.php" data-transition="fade" class="enlace">
                                         Registrate aquí
                                      </a>
                                  </div>
                                   <div>
                                          <a href="" data-transition="fade" class="enlace">
                                              Políticas y ayuda!
                                          </a>
                                      </div>
                                  
                              </form>';
                        }elseif ($estado === "err2") {
                            //si es error de tipo error de estado
                          //se busca a ver si el usuario se aprueba via coordinador
                          if (isset($_GET['priv'])) {
                            //se muestra un mensaje referente su aprobación
                            echo '<h6>';
                                 //se muestra el mensaje de error
                            echo '<p>Este usuario aún no está aprobado, usted debe contactarse con el coordinador</p>para su correcta aprobación';
                            echo '</h6>';
                            echo '  </div>';
                            echo '<a href="/ifisc/index.php" data-ajax="false" data-transition="fade" class="enlace">
                                Volver al Inicio
                            </a>';
                          }else{
                            echo '<h6>';
                                 //se muestra el mensaje de error
                            echo 'Este usuario aún no está aprobado.';
                            echo '</h6>';
                        
                        echo '  </div>';
                         echo '     
                        <form id="form-login" data-ajax="false" action="/ifisc/model/admin/usuario/aprobar_usuario.php" method="POST" class="mi-form">
                             <h3>Ingrese el código de verificación de cuenta que fue enviado al correo de registro</h3>
                            <div data-role="fieldcontain" class="input-box">
                                <label for="textinput1">
                                    Nombre de usuario
                                </label>
                                <input name="usr" id="textinput1" placeholder="Nick" value="" type="text" />
                            </div>
                            <div data-role="fieldcontain">
                                <label for="textinput2">
                                    Código de verificación
                                </label>
                                <input name="cod" id="textinput2" placeholder="Copie y pegue el código aquí" value="" type="text" />
                            </div>
                            <input type="submit" data-inline="true" data-theme="b" value="Validar" class="acep-button" />
                             
                        </form>';
                         }
                      }elseif ($estado === "err3") {
                        //si es error de tipo error de estado
                            echo '<h6>';
                                 //se muestra el mensaje de error
                            echo 'El código de aprobación es incorrecto.';
                            echo '</h6>';
                        
                        echo '  </div>';
                         echo '     
                        <form id="form-login" data-ajax="false" action="/ifisc/model/sesion/seguridad/acceso.php" method="POST" class="mi-form">
                            <div data-role="fieldcontain" class="input-box">
                                <label for="textinput1">
                                    Usuario
                                </label>
                                <input name="usuario" id="textinput1" placeholder="" value="" type="text" />
                            </div>
                            <div data-role="fieldcontain">
                                <label for="textinput2">
                                    Contraseña
                                </label>
                                <input name="clave" id="textinput2" placeholder="" value="" type="password" />
                            </div>
                            <input type="submit" data-inline="true" data-theme="b" value="Aceptar" class="acep-button" />
                            <div>
                                ¿Aún no estás registrado?<a href="/ifisc/local/admin/usuario/new.php" data-transition="fade" class="enlace">
                                   Registrate aquí
                                </a>
                            </div>
                             <div>
                                    <a href="" data-transition="fade" class="enlace">
                                        Políticas y ayuda!
                                    </a>
                                </div>
                            
                        </form>'; 
                      }
                    }else{
                      if (isset($_GET['exito'])) {
                        $exito =$_GET['exito'];
                        echo '  <div id = "exitoBlue">';
                       if ($exito === '1') {
                        echo '<h6>';
                                 //se muestra el mensaje de error
                            echo 'Has sido registrado, ya puedes acceder a tu cuenta.';
                            echo '</h6>';
                        
                        echo '  </div>';
                       }
                      }
                    echo '     
                        <form id="form-login" data-ajax="false" action="/ifisc/model/sesion/seguridad/acceso.php" method="POST" class="mi-form">
                            <div data-role="fieldcontain" class="input-box">
                                <label for="textinput1">
                                    Usuario
                                </label>
                                <input name="usuario" id="textinput1" placeholder="" value="" type="text" />
                            </div>
                            <div data-role="fieldcontain">
                                <label for="textinput2">
                                    Contraseña
                                </label>
                                <input name="clave" id="textinput2" placeholder="" value="" type="password" />
                            </div>
                            <input type="submit" data-inline="true" data-theme="b" value="Aceptar" class="acep-button" />
                            <div>
                                ¿Aún no estás registrado?<a href="/ifisc/local/admin/usuario/new.php" data-transition="fade" class="enlace">
                                   Registrate aquí
                                </a>
                            </div>
                             <div>
                                    <a href="" data-transition="fade" class="enlace">
                                        Políticas y ayuda!
                                    </a>
                                </div>
                            
                        </form>'; 

                      }

                 }
                   
                 
                
                  ?>
           
			<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "iFISC";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
