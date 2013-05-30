
<?php 
session_start();
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta de la cabecera.
$arch_conect = $path_absoluto ."model/sesion/seguridad/open_conn.php";
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
include_once $arch_conect;
require $permisos_location;
//comprobamos los permisos de los usuarios
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //se comprueba si tiene el permiso para editar publicaiones
                    if ($permiso_usuario['EditarPublicaciones']) {
                        //si es cierto continua...
                    }//de lo contrario vuelve al inicio
                    else{
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/index.php"); 
                        exit;
                    }
               
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
//se compueba si el parametro get posee algo
        if (count($_GET)) {
            //si el parametro de id de publicacion posee algo
            if (isset($_GET['Idpub'])) {
                $publicacion_id = $_GET['Idpub'];
            }else{
                //se reenvia a mis publicaciones
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /ifisc/local/articulo/propias.php"); 
                exit;
            }
        }

    
//se comprueba si los datos mandados del la interfás vienen vacios
if (empty($_SESSION['id_usuario']) || empty($_POST['articulo_titulo']) ||
 empty($_POST['contenido']) || empty($_POST['categoria'])) {
    //se envia a la pagina del nuevo articulo con el error correspondiente
    header("HTTP/1.1 301 Moved Permanently");
    if (isset($_POST['categoria'])) {
       header("Location: /ifisc/local/articulo/editar.php?error=data1&&Idpub=".$publicacion_id); 
    }else{
        header("Location: /ifisc/local/articulo/nuevo_tipo.php"); 
    }
    exit;
}//si no... continua

//se almacenan las variables que vienen de la interfaz
 $id_usuario = $_SESSION['id_usuario'];
 //se guardan todos los datos que esten setteados
 //los demás se almacenan vacios o por default
 $titulo = $_POST['articulo_titulo'];
 $cuerpo= $_POST['contenido'];
 if (isset($_POST['in_fecha'])) {
     $fecha = $_POST['in_fecha'];
 }else{
     $fecha ="";
 }
 
 $id_categoria = $_POST['categoria'];
 $estado = 2;     // la publicación se guarda con estado de pendiente de aprobación
 $publico = $_POST['publico'];
 ////////////////////////////////////
 if (isset($_POST['hora'])) {
    //si existe el valor se le asigna a la variable
    //$f_hora = fix_strtotime('H:i:s',$_POST['hora'].':00');
     //$hora = $_POST['hora'];
     $hora= strtotime("".$_POST['hora'].":00");
     $hora = date('H:i:s',$hora);
 }else{
    //sino... se guarda con el valor por defecto
    $hora= null;
 }
 if (isset($_POST['lugar'])) {
    //si existe el valor se le asigna a la variable
     $lugar=$_POST['lugar'];
 }else{
    //sino... se guarda con el valor por defecto
    $lugar="";
 }
  if (isset($_POST['organiz'])) {
    //si existe el valor se le asigna a la variable
     $organizadores=$_POST['organiz'];
 }else{
    //sino... se guarda con el valor por defecto
    $organizadores="";
 }
 if (isset($_POST['contacto'])) {
    //si existe el valor se le asigna a la variable
     $contacto=$_POST['contacto'];
 }else{
    //sino... se guarda con el valor por defecto
    $contacto="";
 }
 if (isset($_POST['tel'])) {
    //si existe el valor se le asigna a la variable
     $tel=$_POST['tel'];
 }else{
    //sino... se guarda con el valor por defecto
    $tel="";
 }
 //////////////////////////////////////////////
 if (isset($_POST['fi_fecha'])) {
    //si existe el valor se le asigna a la variable
     $fecha_fin=$_POST['fi_fecha'];
 }else{
    //sino... se guarda con el valor por defecto
    $fecha_fin="";
 }
  if (isset($_POST['web'])) {
    //si existe el valor se le asigna a la variable
     $web=$_POST['web'];
 }else{
    //sino... se guarda con el valor por defecto
    $web="";
 }
 ///////////////////////////////////////////
 if (isset($_POST['posicion'])) {
    //si existe el valor se le asigna a la variable
     $posicion=$_POST['posicion'];
 }else{
    //sino... se guarda con el valor por defecto
    $posicion="";
 }
 if (isset($_POST['salario'])) {
    //si existe el valor se le asigna a la variable
     $salario=$_POST['salario'];
 }else{
    //sino... se guarda con el valor por defecto
    $salario="";
 }
 if (isset($_POST['correo'])) {
    //si existe el valor se le asigna a la variable
     $mail=$_POST['correo'];
 }else{
    //sino... se guarda con el valor por defecto
    $mail="";
 }
 if (isset($_POST['requisitos'])) {
    //si existe el valor se le asigna a la variable
     $requisitos=$_POST['requisitos'];
 }else{
    //sino... se guarda con el valor por defecto
    $requisitos="";
 }
///////////////////////////////////////////////////
 if (isset($_POST['perfil'])) {
    //si existe el valor se le asigna a la variable
     $perfil=$_POST['perfil'];
 }else{
    //sino... se guarda con el valor por defecto
    $perfil="";
 }
 if (isset($_POST['costo'])) {
    //si existe el valor se le asigna a la variable
     $costo=$_POST['costo'];
 }else{
    //sino... se guarda con el valor por defecto
    $costo="";
 }
 if (isset($_POST['campo'])) {
    //si existe el valor se le asigna a la variable
     $campo=$_POST['campo'];
 }else{
    //sino... se guarda con el valor por defecto
    $campo="";
 }
 if (isset($_POST['duracion'])) {
    //si existe el valor se le asigna a la variable
     $duracion=$_POST['duracion'];
 }else{
    //sino... se guarda con el valor por defecto
    $duracion="";
 }
 if (isset($_POST['web_plan'])) {
    //si existe el valor se le asigna a la variable
     $web_plan=$_POST['web_plan'];
 }else{
    //sino... se guarda con el valor por defecto
    $web_plan="";
 }
 if (isset($_POST['titulo_carrera'])) {
    //si existe el valor se le asigna a la variable
     $titulo_carrera=$_POST['titulo_carrera'];
 }else{
    //sino... se guarda con el valor por defecto
    $titulo_carrera="";
 }
 if (isset($_POST['nivel'])) {
    //si existe el valor se le asigna a la variable
     $nivel=$_POST['nivel'];
 }else{
    //sino... se guarda con el valor por defecto
    $nivel="";
 }
 ////////////////////////////////////////////////
 if (isset($_POST['fax'])) {
    //si existe el valor se le asigna a la variable
     $fax=$_POST['fax'];
 }else{
    //sino... se guarda con el valor por defecto
    $fax="";
 }
 if (isset($_POST['apost'])) {
    //si existe el valor se le asigna a la variable
     $apost=$_POST['apost'];
 }else{
    //sino... se guarda con el valor por defecto
    $apost="";
 }
 if (isset($_POST['horario'])) {
    //si existe el valor se le asigna a la variable
     $horario=$_POST['horario'];
 }else{
    //sino... se guarda con el valor por defecto
    $horario="";
 }

      // la publicación se guarda con estado de pendiente de aprobación

//guardando los datos,   falta un valor, noner el auto incremental en el codigo
 
 $Consulta2 = "UPDATE publicacion SET
                                        id_categoria = '$id_categoria',
                                        Titulo = '$titulo',
                                         Cuerpo = '$cuerpo',
                                        Fecha = '$fecha',
                                        Destino ='$publico',
                                        FechaMod = now(),
                                        Hora = '$hora', 
                                        Lugar = '$lugar', 
                                        Organizadores = '$organizadores', 
                                        Contacto = '$contacto', 
                                        Telefono = '$tel',
                                        URLWeb = '$web', 
                                        FechaCaduca ='$fecha_fin',
                                        Correo = '$mail', 
                                        Puesto = '$posicion', 
                                        Requisitos = '$requisitos', 
                                        Salario = '$salario',
                                        Perfil_egresado = '$perfil', 
                                        Costo = '$costo', 
                                        Campo_laboral = '$campo', 
                                        Duracion = '$duracion', 
                                        URLPlan = '$web_plan', 
                                        Titulo_profesional = '$titulo_carrera', 
                                        Nivel_academico = '$nivel',
                                        Fax = '$fax', 
                                        Apartado_P = '$apost', 
                                        Horario = '$horario'
                                          WHERE id = '$publicacion_id'";

//Ejecuto la sentencia 
$rs = mysql_query($Consulta2,$conn); 
/*comprobamos el exito de la consulata*/
if ($rs){ 
	header("Location: /ifisc/local/articulo/propios.php"); 
	exit();
}else{ 
	echo "Existe un problema ".mysql_error(); 
} 
?>