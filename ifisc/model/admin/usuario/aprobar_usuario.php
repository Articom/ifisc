<?php
session_start();
$path = $_SERVER['PHP_SELF']; 
    $temp = explode("/", $path); 
    $path_absoluto = "/"; 
    for($i=3;$i<count($temp);$i++) 
    $path_absoluto .= "../"; 

    //variable que indica la localizacion absoluta del archivo.
    $conection_file = $path_absoluto ."model/sesion/seguridad/open_conn.php";
include_once $conection_file;

//verificamos si el usuario va a ser aprobado por correo o por el administrador
if (isset($_GET['cod']) && isset($_GET['usr'])) {
  //se va a aprobar el usuario por medio de la url del correo
  $usuario = $_GET['usr'];
  $codigo_introducido = $_GET['cod'];
  $aprobacion=1;
}elseif (isset($_POST['cod']) && isset($_POST['usr'])) {
  //Se va a aprobar por medio del codigo de verificacion en la web
  $usuario = $_POST['usr'];
  $codigo_introducido = $_POST['cod'];
  $aprobacion=1;
}else{
  // de otra forma se va a aprobar por medio de un administrador
  $usuario = $_POST['nickname'];
  $aprobacion=2;
}
//se crea uan consulta para buscar el id de usuario segun el nombre de usuario
$ssql ="SELECT * FROM usuario u where u.Nombre= '$usuario'";
    
//Ejecuto la sentencia 
$rs = mysql_query($ssql,$conn); 
//variable que contiene el id de usuario
$fila= mysql_fetch_assoc($rs); 
$id_usuario = $fila['id'];
  if (count(mysql_num_rows($rs))!=0){ 
      //usuario existe en la base de datos
//comprobamos nuevamente de que manera se va a aprobar
    //si se va a aprobar por medio de la url al correo o introduccion de codigo
      if ($aprobacion === 1) {
              //se comprueba que el codigo que se introdujo fue el correcto
                  //se incluye el archivo que busca los datos del usuario
              $clase_datos_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
              include $clase_datos_usuario_location;
              //se crea un objeto para acceder a los metodos de los datos del usuario
              $obj_datos_usuario = new datos_usuario;
              //se busca el código unico del usuario
              $codigo_unico = $obj_datos_usuario->getCodigoUsuarioByIdUsuario($id_usuario);
              //se compueba la validez del codigo
              if ($codigo_introducido===$codigo_unico) {
                //el codigo es valido
                $estado_nuevo = '1';
              }else{
                // de devuelve un error
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /ifisc/local/sesion/login.php?error=err3"); 
                exit;
              }
    }elseif ($aprobacion===2) {
                //comprobamos si se ha presionado el boton de aprobar o denegar
              if ($_POST['submit'] === "Aprobar"){
                //se le coloca el estado de 1 = aprobado
                $estado_nuevo = '1';
              }else{
                // se le coloca el estado de 3 = denegado
                 $estado_nuevo = '3';
              }
    }
      //le hacemos un update a el estado del usuario
      $ssql2 ="UPDATE usuario SET Estado = '$estado_nuevo' WHERE id ='$id_usuario'";
      //se ejecuta la consulta
      $rs2 = mysql_query($ssql2,$conn); 
      // Segun la aprobacion que se haya hecho se retorna 
       if ($aprobacion === 1) {
        //se busca el correo
        $correo = $fila['mail'];
           //se retorna a la pagina de aprobacion de usuario
        //funcion para mandar mail

          header ("Location: /ifisc/model/common/mail/mail_registro.php?correo=".$correo."&&nombre=".$usuario."&&tipo=etapa2");  
          exit;
       }else{
           //se retorna a la pagina de aprobacion de usuario
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: /ifisc/local/admin/usuario/aprobar.php"); 
          exit;
       }
     
     }

 ?>
