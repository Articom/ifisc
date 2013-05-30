<?php 
    $path = $_SERVER['PHP_SELF']; 
    $temp = explode("/", $path); 
    $path_absoluto = "/"; 
    for($i=3;$i<count($temp);$i++) 
    $path_absoluto .= "../"; 

    //variable que indica la localizacion absoluta de la cabecera.
    $header_location = $path_absoluto ."local/_header.php";
    $carreras_location = $path_absoluto ."model/common/load_all_carreras.php";
    $roles_location = $path_absoluto ."model/common/load_role_public.php";
    //texto del titulo de la ventana
    $titulo = "Nuevo usuario";
    $show_menu = false;
    //se renderiza el html de la cabecera
    include $header_location;
    //se invoca el archivo que busca todas las carreras
    include_once $carreras_location;
    //se invoca el archivo que busca todas los roles de aprobacion publica
    include_once $roles_location;
?>
                <div id = "errorRed">
                <?php 
                     $errorType ="";
                    //contamos si se ha registrado algun error
                    if (isset($_GET["user_error"])) {
                       $errorType = $_GET["user_error"];
                         if ($errorType === "nickname") {
                            //si es error de tipo usuario duplicado
                        echo '<h6>';
                             //se muestra el mensaje de error
                        echo 'Este nombre ya está en uso, Intenta con uno diferente.';
                        echo '</h6>';
                        }elseif ($errorType === "re-pasword") {
                            //si el error es de tipo contrasenia erronea
                        echo '<h6>';
                             //se muestra el mensaje de error
                        echo 'Las contraseñas no coinciden.';
                        echo '</h6>';
                        }elseif ($errorType === "ced") {
                            //si el error es de tipo contrasenia erronea
                        echo '<h6>';
                             //se muestra el mensaje de error
                        echo 'La cédula ya esta en uso.';
                        echo '</h6>';
                        }elseif ($errorType === "miss") {
                            //si el error es de tipo dato faltante
                        echo '<h6>';
                             //se muestra el mensaje de error
                        echo 'Debe llenar todos los datos requeridos.';
                        echo '</h6>';
                        }
                    }
                 ?>
                 </div>
                
                <form id="new-user" data-ajax="false" action="/ifisc/model/admin/usuario/save_user.php" method="POST" >
                    <div data-role="fieldcontain" class="text-box">
                        <label for="textinput1">
                            Nombre o NICK
                        </label>
                        <input name="nickName" id="textinput1" placeholder="" value="" type="text" />
                    </div>
                    <div data-role="fieldcontain" class="text-box">
                        <label for="textinput5">
                            Contaseña
                        </label>
                        <input name="password" id="textinput5" placeholder="" value="" type="password" />
                    </div>
                    <div data-role="fieldcontain" class="text-box">
                        <label for="textinput4">
                            Repita la contaseña
                        </label>
                        <input name="re-password" id="textinput4" placeholder="" value="" type="password" />
                    </div>
                    <div data-role="fieldcontain" class="text-box">
                        <label for="textinput2">
                            Nombre
                        </label>
                        <input name="nombre" id="textinput2" placeholder="" value="" type="text" />
                    </div>
                     <div data-role="fieldcontain" class="text-box">
                        <label for="textinput3">
                            Apellido
                        </label>
                        <input name="apellido" id="textinput3" placeholder="" value="" type="text" />
                    </div>
                     <div data-role="fieldcontain" class="text-box">
                        <label for="textinput9">
                            Cédula
                        </label>
                        <input name="cedula" id="textinput9" placeholder="" value="" type="text" />
                    </div>
                    <div data-role="fieldcontain" class="text-box">
                        <label for="textinput4">
                            E-mail
                        </label>
                        <input name="correo" id="textinput4" placeholder="" value="" type="email" />
                    </div>
                    <div data-role="fieldcontain" class="text-box">
                        <label for="datepicker">
                            Fecha de nacimiento
                        </label>
                        <input name="fechnac" id="datepicker" placeholder="" value="" type="date" />
                    </div>
                    <div id="sex-button" data-role="fieldcontain">
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
                    </div>
                     <div data-role="fieldcontain">
                        <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                            <legend>
                                Funci&oacute;n dentro de la UTP
                            </legend>

                            <?php 
                                 $indice = 1;
                               while($row1 = mysql_fetch_array($rolesPublicos)){
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
                             ?>

                        </fieldset>
                    </div>
                    <div data-role="fieldcontain">
                    <label for="feed">
                        Recibir notificaciones al correo
                    </label>
                    <select name="feed" id="feed" data-theme="a" data-role="slider"
                    data-mini="true">
                        <option value="off">
                            No
                        </option>
                        <option value="on">
                            Si
                        </option>
                    </select>
                </div>
                    <input type="submit" data-inline="true" data-theme="a" value="Registrar" class="acep-button" />
                </form>
            <?php 
                //variable que indica la localizacion absoluta del footer.
                $footer_location = $path_absoluto ."local/_footer.php";
                //se le da el texto a el fondo
                $footer_string = "";
                $show_footer=true;
                //se incluye el archivo segun la variable de posicion absoluta
                include $footer_location;
             ?>