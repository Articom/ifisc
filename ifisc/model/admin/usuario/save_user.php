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
//variable de los datos que se mandan desde la interfaz
//comprueba que ninguno de los datos requeridos esten vacios
if (!isset($_POST['sex']) || empty($_POST["nickName"]) || empty($_POST["password"]) || empty($_POST["correo"]) || empty($_POST["cedula"]) || !isset($_POST["rol"])) {
  //si ocurre cualquiera de las anteriores 
  //se devuelve el error al registro
    header ("Location: /ifisc/local/admin/usuario/new.php?user_error=miss");  
    exit;
}
$usuario = $_POST["nickName"];
$password = $_POST["password"];
$correo = $_POST["correo"];
$cedula = $_POST["cedula"];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fechaNac = $_POST['fechaNac'];
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
if ($_POST['sex'] === "mas") {
  $sexo = true;
}else{
  $sexo = false;
}
$role_id = $_POST['rol'];
//$carrera_id = $_POST['carrera'];
//codigo random para la aprobacion de email
$codigo = substr(md5(rand()), 0, 7);

//se crea uan consulta para ver si ese nickname ya esta en uso
$ssql ="SELECT * FROM usuario u where u.Nombre= '$usuario'";

//Ejecuto la sentencia 
$rs = mysql_query($ssql,$conn); 
//variable que contiene los datos del usuario

//si la consulta arroja algun resultado, el nickname ya esta en uso
  if (mysql_num_rows($rs)!=0){ 
     	//usuario en uso
      //retornamos a la pagina de inscripcion 
     	header ("Location: /ifisc/local/admin/usuario/new.php?user_error=nickname");	
  	  exit;
  }else { 
    //de no existir comprobamos la validez de la contraseña
    if ($password === $_POST["re-password"]) {
      //si la contrasenia y la repeticion son identicas
      //comprobamos que el email no se este utilizando
      //preparamos la consulta
      $ssql ="SELECT * FROM usuario u where u.mail= '$correo'";
      $rs = mysql_query($ssql,$conn); 
      //si la consulta arroja algun resultado el e-mail esta en uso
       if (mysql_num_rows($rs)!=0){ 
        //devolvemos el error a la pagina
          header ("Location: /ifisc/local/admin/usuario/new.php?user_error=email");  
          exit;
      }else{
        //si el email no existe se comprueba la duplicidad de la cedula
        $ssqlced = "SELECT * FROM datosusuario WHERE Cedula = '$cedula'";
        $resultCedula = mysql_query($ssqlced,$conn); 
        if (mysql_num_rows($resultCedula)!=0){
           //devolvemos el error a la pagina
          header ("Location: /ifisc/local/admin/usuario/new.php?user_error=ced");  
          exit;
        }else{             
            //EN ESTE PUNTO TODO ES CORRECTO
            //se guardan los datos
            //se prepara la consulta de insert
            //el estado de no aprobado es el 2
            //se encripta la contraseña con md5
           $sqlInsrt = "INSERT INTO usuario
              (Nombre, Password, Estado, mail, id_role, Feed, AlertaPendiente)
              VALUES
              ( '".$_POST['nickName']."',
                '".md5($password)."',
                '2',
                '".$_POST['correo']."', '$role_id', '$send_feed', false
              )";
          $rs = mysql_query($sqlInsrt,$conn); 
          //lluego que se guardaron los datos 
          //se buscan a partir del nombre de usuario
          $sqlconsulta = "SELECT id FROM usuario u WHERE u.Nombre = '$usuario'";
          //se ejecuta la consulta a la BD
          $resultado = mysql_query($sqlconsulta,$conn); 
          //se busca el id del usuario guardado
          $usuario_saved = mysql_fetch_assoc($resultado);
          $id_usuario_saved = $usuario_saved['id'];
          //vamos a guardar los datos detallados de los usuarios
          $sqlInsertdatousuario = "INSERT INTO datosusuario
                                  (Nombre1, Apellido1, Cedula,
                                    Codigo, id_usuario, FechaInscrip , esHombre, FechaNac )
                                VALUES
                                (
                                  '$nombre', '$apellido', '$cedula', '$codigo', '$id_usuario_saved',
                                  now(), '$sexo', '$fechaNac'
                                )";
          //se ejecuta la consulta para guardar los datos de usuario
          mysql_query($sqlInsertdatousuario,$conn); 
          //#implementar funcion para mandar mail
          //funcion para mandar mail
          //solo si es de rol estudiante
          if ($role_id === '3') {
             header ("Location: /ifisc/model/common/mail/mail_registro.php?correo=".$_POST['correo']."&&nombre=".$_POST['nickName']."&&tipo=etapa1&&pass=".$password."&&cod=".$codigo);  
              exit;
          }else{
            //se encia al inicio de session
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/sesion/login.php"); 
            exit;
          }
         
          }
      }
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: /ifisc/index.php"); 
      exit;
    }else{
      //se son totalmente diferentes
      //retornamos el error a la pagina de subscipcion
      header ("Location: /ifisc/local/admin/usuario/new.php?user_error=re-pasword");  
      exit;
    }
     	
  } 

 ?>