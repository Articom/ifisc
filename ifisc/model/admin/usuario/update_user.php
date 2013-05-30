<?php
session_start();
$path = $_SERVER['PHP_SELF']; 
    $temp = explode("/", $path); 
    $path_absoluto = "/"; 
    for($i=3;$i<count($temp);$i++) 
    $path_absoluto .= "../"; 

    //variable que indica la localizacion absoluta del archivo.
    $conection_file = $path_absoluto ."model/sesion/seguridad/open_conn.php";
	require $conection_file;
    $clase_usuario_location = $path_absoluto ."model/class_usuario.php";
	$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
    $clase_datos_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
    include $clase_usuario_location;
    include $clase_datos_usuario_location;
        //se carga el archivo que realiza la consulta y extrae los permisos
    require $permisos_location;
	if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
        $estado_sesion = $_SESSION['autentificado'];
        if ($estado_sesion === "SI") {
        	$loggedUser = $_SESSION['logged_user'];
        	
            $obj_usuario = new usuarioN;
            $obj_datos_usuario = new datos_usuario;
        	//comprobamos los permisos de los usuarios
            
                //comprobamos si el usuario a editar es el mismo que el de la session
                if ($_GET['user'] === $loggedUser) {
                    //si son iguales se trata del mismo usuario
                    //comprobamos si tiene permisos de edicion del usuario propio
                    if ($permiso_usuario['EditarMiUsuario']) {
                        //si tiene permisos de ediar su propio usuario... continua
                    }else{
                        //se redirige al perfil
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                        exit;
                    }                    
                }//si no se va a editar el perfil propio 
                else{
                    //comprobamos si tiene permisos de edicion del usuario 
                    if ($permiso_usuario['EditarUsuario']) {
                        //si tiene permisos de ediar el usuario... continua
                    }else{
                        //se redirige al perfil
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                        exit;
                    }                    
                }

                
                $submit_Name = $_POST['submit'];
                    if ($submit_Name === 'Resetear contraseña') {
                      //si es un evento de tipo 3 es un reseteo de contraseña
                            //se obtiene le valor de la interfaz
                            //lo convertimos a MD5
                            $Pass_new = md5($_POST['new-password']);
                            //se crea un objeto de tipo datos de usuario
                            $UsuarioActual = $obj_usuario->getUsuarioByName($_GET['user']);
                            //se busca el id de ese usuario
                            $id_user = $UsuarioActual['id'];
                            $Consulta2 = "UPDATE usuario SET
                                          Password = '$Pass_new'
                                          WHERE id = '$id_user'";
                            mysql_query($Consulta2,$conn);
                            //luego se redirige el usuario al perfil
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                            exit;
                    }
                    
                    //se valida los datos que se han editado
                            //si es un evento de tipo 1 son los datos basicos
                        elseif ($_GET['edit'] === '1'){
                            $NombreUser_var = $_POST['nickName'];
                            //contraseña
                            $Pass = $_POST['old-password'];
                            $Pass_new = $_POST['new-password'];                            
                            $Pass_re = $_POST['re-password'];
                            $Cedula_var = $_POST['cedula'];
                            $Correo_var = $_POST['correo'];
                            if (isset($_POST['feed'])) {
                                $notificaciones =$_POST['feed'];
                              if ($notificaciones==="on") {
                                $send_feed = true;
                              }else{
                                $send_feed = false;
                              }
                                }else{
                                    $send_feed = false;
                                }


                            //se consiguen los datos actuales para hacer la comparacion de la cedula vieja
                            $UsuarioActual = $obj_usuario->getUsuarioByName($_GET['user']);
                            //se cargan los datos detallados para hacer una comparacion
                            $UsuarioDetalladoActual = $obj_datos_usuario->getDatosDeUsuarioById($UsuarioActual['id']);
                            $id_user = $UsuarioActual['id'];
                            //las siguientes condiciones son implementadas por si el usuario no elige genero alguno
                            if (!isset($_POST['sex'])) {
                                 //si no elige se carga la actual de la base de datos
                                $Genero_var = $UsuarioDetalladoActual['esHombre'];
                            }else{
                                 //si elige algun genero se guarda su eleccion
                                $Genero_var = $_POST['sex'];
                            }
                            //las siguientes condiciones son implementadas por si el usuario no elige carrera alguna
                            if (isset($_POST['carrera'])) {
                                //si elige alguna carrera se guarda su eleccion
                                 $Carrera_var = $_POST['carrera'];
                            }else{
                                //si no elige se carga la actual de la base de datos
                                 $Carrera_var = $UsuarioDetalladoActual['id_carrera'];
                            }
                            //si el usuario puede resetar la contraseña
                             if ($_GET['user'] === $loggedUser) {
                                 //si el password nuevo es diferente a la repeticion
                                if ((($Pass_new ==="") && ($Pass_re==="")) && ($Pass==="")) {
                                    $Pass_new=$UsuarioActual['Password'];  
                                }elseif ($Pass_new === $Pass_re) {
                                    //se comprueba si la contraseña antigual es como se señala
                                    if (md5($Pass) === $UsuarioActual['Password']) {
                                       //si las contraseña son iguales
                                        //seteamos el nuevo password en MD5
                                        $Pass_new = md5($_POST['new-password']);
                                        }//se muestra el mensaje de error al validar las contraseñas
                                    else{
                                        //se devuelve el tipo de error al registro
                                        header("HTTP/1.1 301 Moved Permanently");
                                        header("Location: /ifisc/local/usuario/edit.php?edit=".$_GET['edit']."&&user=".$_GET['user']."&&error=pass1"); 
                                        exit;
                                    }                                
                                }//si las contraseñas son diferentes
                                else{
                                    //se devuelve el tipo de error al registro
                                    header("HTTP/1.1 301 Moved Permanently");
                                    header("Location: /ifisc/local/usuario/edit.php?edit=".$_GET['edit']."&&user=".$_GET['user']."&&error=pass2"); 
                                    exit;
                                }     

                             }else{
                                //el usuario es diferente al de la edicion...continua
                                //no se va a cambiar la contraseña
                                 $Pass_new=$UsuarioActual['Password'];                                   
                             }
                            
                                    //si las contraseñas no fueron cambiadas
                                    if ((($Pass === $Pass_re) && ($Pass_new === $Pass)) && $Pass === "") {
                                        $Pass_new=$UsuarioActual['Password'];
                                    }
                                    //si el correo nuevo es diefrente al correo actual
                                        if ($UsuarioActual['mail'] === $Correo_var) {
                                               //continua...              
                                        }else{
                                            //Se hace la comparacion a ver si el correo 
                                            //esta sieno usado por otra persona
                                            $UsuarioCompare = $obj_usuario->getUsuarioByCorreo($Correo_var);
                                            //si devuelve algun id, el correo esta siendo utilizado por otra persona
                                            if (!empty($UsuarioCompare['id'])) {
                                                //se redirige al usuario a la pagina de edicion 
                                                 //se devuelve el tipo de error al registro
                                                header("HTTP/1.1 301 Moved Permanently");
                                                header("Location: /ifisc/local/usuario/edit.php?edit=".$_GET['edit']."&&user=".$_GET['user']."&&error=mail"); 
                                                exit;
                                            }
                                            //si no esta siendo utilizado continua con el procedimiento 
                                        }
                                        //comprobamos el cambio de la cedula a ver si es unica y otro usuario no la esta utilizando
                                        if ($Cedula_var === $UsuarioDetalladoActual['Cedula']) {
                                            //continua con el proceso...
                                        }else{
                                            //Se hace la comparacion a ver si la cedula
                                            //esta sieno usado por otra persona
                                            $UsuarioCompareCedula = $obj_datos_usuario->getDatosDeUsuarioByCedula($Cedula_var);
                                            //si devuelve algun id, la cedula esta siendo utilizado por otra persona
                                            if (!empty($UsuarioCompareCedula['Cedula'])) {
                                                //se redirige al usuario a la pagina de edicion 
                                                 //se devuelve el tipo de error al registro
                                                header("HTTP/1.1 301 Moved Permanently");
                                                header("Location: /ifisc/local/usuario/edit.php?edit=".$_GET['edit']."&&user=".$_GET['user']."&&error=ced"); 
                                                exit;
                                            }
                                            //si no esta siendo utilizado continua con el procedimiento 
                                        }
                                        //por ultimo se comprueba la validez del nick o nombre de usuario
                                        if ($_POST['nickName']===$_GET['user']) {
                                           //si son identicos no se desea cambiar el nombre de usuario
                                            //continua...
                                            //variable bandera para poder saber si se necesita reiniciar la session
                                            $doReiniciarSesion = false;
                                            //es falso porque el nombre de usuario no se va a cambiar
                                        }//de otra forma... verificamos que el nuevo nombre no este siendo utilizado por ninguna persona
                                        else {
                                            //se crea un objeto para comprbar los nombre de usuario
                                            $UsuarioNuevo = $obj_usuario->getUsuarioByName($_POST['nickName']);
                                            //si devuelve algun id, significa que el usuario ya lo tiene otra persona
                                              if (!empty($UsuarioNuevo['id'])) {
                                            //se devuelve el error al registro
                                            header("HTTP/1.1 301 Moved Permanently");
                                            header("Location: /ifisc/local/usuario/edit.php?edit=".$_GET['edit']."&&user=".$_GET['user']."&&error=userName"); 
                                            exit;
                                            }else{
                                                //el usuario es valido
                                                //luego de cambiar el nombre se tiene que cerrar la sesion
                                                //colocamos una variable bandera
                                                $doReiniciarSesion = true;
                                            }
                                        }
                                    //Se comprueban los permisos de edicion
                                    if ($permiso_usuario['CambiarRol'] && $permiso_usuario['CambiarNICK']){
                                        //se comprueba si el correo que introdujo esta siendo utilizado por otra persona 
                                         //si puede cambiar el rol y el nick del usuario se crea una consulta
                                          //las siguientes condiciones son para comprobar si el usuario eligio algun rol
                                        if (isset($_POST['rol'])) {
                                             //si elige algun rol se guarda su eleccion
                                            $Rol_var = $_POST['rol'];
                                        }else{
                                                //si no elige se carga el actual de la base de datos
                                                $Rol_var = $UsuarioActual['id_role'];
                                        }
                                        //se crean las consultas para actualizar los datos
                                        $Consulta2 = "UPDATE usuario SET
                                                        Nombre = '$NombreUser_var', 
                                                        Password = '$Pass_new', 
                                                        mail = '$Correo_var', 
                                                        id_role = '$Rol_var',
                                                        Feed = '$send_feed'
                                                        WHERE id = '$id_user'";
                                        $Consulta1 = "UPDATE datosusuario SET
                                                        Cedula = '$Cedula_var',
                                                        id_carrera = '$Carrera_var',
                                                        esHombre = '$Genero_var'
                                                        WHERE id_usuario = '$id_user'";
                                        //se ejecutan las consultas en la base de datos
                                        mysql_query($Consulta2,$conn);
                                        mysql_query($Consulta1,$conn);
                                        //se evalua si es necesario reiniciar la session
                                        if ($doReiniciarSesion) {
                                            //se reasigna a la session el nuevo nombre de usuario
                                            $_SESSION['logged_user'] =$NombreUser_var;
                                        }
                                        //luego se redirige el usuario al perfil
                                        header("HTTP/1.1 301 Moved Permanently");
                                        header("Location: /ifisc/local/usuario/perfil.php?user=".$NombreUser_var); 
                                            exit;
                                     }//si tiene solo permisos de editar el rol del usuario
                                     elseif ($permiso_usuario['CambiarRol']){
                                        //si se puede cambiar el rol se crea la consulta de
                                         //las siguientes condiciones son para comprobar si el usuario eligio algun rol
                                        if (isset($_POST['rol'])) {
                                             //si elige algun rol se guarda su eleccion
                                            $Rol_var = $_POST['rol'];
                                        }else{
                                                //si no elige se carga el actual de la base de datos
                                                $Rol_var = $UsuarioActual['id_role'];
                                        } 
                                        $Consulta2 = "UPDATE usuario SET
                                                            Password = '$Pass_new', 
                                                            mail = '$Correo_var', 
                                                            id_role = '$Rol_var',
                                                            Feed = '$send_feed'
                                                            WHERE id = '$id_user'";
                                        $Consulta1 = "UPDATE datosusuario SET
                                                            Cedula = '$Cedula_var',
                                                            id_carrera = '$Carrera_var',
                                                            esHombre = '$Genero_var'
                                                            WHERE id_usuario = '$id_user'";
                                        //se ejecutan las consultas en la base de datos
                                        mysql_query($Consulta2,$conn);
                                        mysql_query($Consulta1,$conn);
                                        //luego se redirige el usuario al perfil
                                        header("HTTP/1.1 301 Moved Permanently");
                                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                                            exit;
                                    }//si tiene permiso de editar el nick del usuario
                                    elseif ($permiso_usuario['CambiarNICK']) {
                                        $Consulta2 = "UPDATE usuario SET
                                                            Nombre = '$NombreUser_var', 
                                                            Password = '$Pass_new', 
                                                            mail = '$Correo_var',
                                                            Feed = '$send_feed'
                                                            WHERE id = '$id_user'";
                                        $Consulta1 = "UPDATE datosusuario SET
                                                            Cedula = '$Cedula_var',
                                                            id_carrera = '$Carrera_var',
                                                            esHombre = '$Genero_var'
                                                            WHERE id_usuario = '$id_user'";
                                        //se ejecutan las consultas en la base de datos
                                        mysql_query($Consulta2,$conn);
                                        mysql_query($Consulta1,$conn);
                                        //se evalua si es necesario reiniciar la session
                                        if ($doReiniciarSesion) {
                                            //se reasigna a la session el nuevo nombre de usuario
                                            $_SESSION['logged_user'] =$NombreUser_var;
                                        }
                                        //luego se redirige el usuario al perfil
                                        header("HTTP/1.1 301 Moved Permanently");
                                        header("Location: /ifisc/local/usuario/perfil.php?user=".$NombreUser_var); 
                                            exit;
                                    }else{
                                        //si no... se modifican los datos normalmente sin privilegios
                                         $Consulta2 = "UPDATE usuario SET 
                                                            Password = '$Pass_new', 
                                                            mail = '$Correo_var',
                                                            Feed = '$send_feed'
                                                            WHERE id = '$id_user'";
                                        $Consulta1 = "UPDATE datosusuario SET
                                                            Cedula = '$Cedula_var',
                                                            id_carrera = '$Carrera_var',
                                                            esHombre = '$Genero_var'
                                                            WHERE id_usuario = '$id_user'";
                                        //se ejecutan las consultas en la base de datos
                                        mysql_query($Consulta2,$conn);
                                        mysql_query($Consulta1,$conn);
                                        //luego se redirige el usuario al perfil
                                        header("HTTP/1.1 301 Moved Permanently");
                                        header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                                        exit;
                                    }                                                       

                        } //si es un evento de tipo 2 son los datos detallados
                        elseif ($_GET['edit'] === '2') {
                            //se crea un objeto de tipo datos de usuario
                            $UsuarioActual = $obj_usuario->getUsuarioByName($_GET['user']);
                            //se busca el id de ese usuario
                            $id_user = $UsuarioActual['id'];
                            //se van a editar los datos detallados propios
                            $primerNombre = $_POST['name1'];
                            $segundoNombre = $_POST['name2'];
                            $apellido = $_POST['apellido1'];
                            $apellidoMaterno = $_POST['apellido2'];
                            $fechaNac = $_POST['fechaNac'];
                            $fechaMatr = $_POST['fechaMatr'];
                            $Consulta1 = "UPDATE datosusuario SET
                                            Nombre1 = '$primerNombre',
                                            Nombre2 = '$segundoNombre',
                                            Apellido1 = '$apellido',
                                            Apellido2 = '$apellidoMaterno',
                                            FechaNac = '$fechaNac',
                                            FechaMatr = '$fechaMatr'
                                            WHERE id_usuario = '$id_user'";
                            // se ejecuta la consulta 
                            mysql_query($Consulta1,$conn);
                            //luego se redirige el usuario al perfil
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: /ifisc/local/usuario/perfil.php?user=".$_GET['user']); 
                                exit;
                        }
                    
                
    	   }
        }
    ?>

