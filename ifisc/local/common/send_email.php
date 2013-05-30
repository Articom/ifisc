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
$titulo = "Contacto";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
    }else{
        $show_menu = false;
    }
}else{
    $show_menu = false;
}
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->

        <ul data-role="listview" data-divider-theme="a" data-inset="true">
            <li data-role="list-divider" role="heading">
                Enviar E-mail
            </li>
            <li data-theme="c">
                 <form action="/ifisc/model/common/mail/enviarSMS.php" data-ajax="false" method="POST" >
		            <div data-role="fieldcontain">
		                <label for="textinput1">
		                    Correo
		                </label>
		                <input name="correo" id="textinput1" placeholder="" value="" type="text" data-mini="true">
		            </div>
		            <div data-role="fieldcontain">
		                <label for="textinput1">
		                    Nombre
		                </label>
		                <input name="nombre" id="textinput1" placeholder="" value="" type="text" data-mini="true">
		            </div>
		            <div data-role="fieldcontain">
		                <label for="textarea1">
		                    Mensaje
		                </label>
		                <textarea name="mensaje" id="textarea1" placeholder="" data-mini="true"></textarea>
		            </div>
		            <input type="submit" data-inline="true" data-theme="a" value="Enviar"
		            data-mini="true">
       			 </form>
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
