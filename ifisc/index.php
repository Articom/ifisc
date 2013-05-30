<?php 
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
$titulo = "iFISC";
//inicializamos la variable de estado de la sesion
$estado_sesion ="NO";
//comprobamos si el usuario ha iniciado sesion
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
include $path_absoluto ."model/class_display.php";
$obj_display = new displayes;
//se renderiza el html de la cabecera
include $header_location; 

?>
<div style=" text-align:center">
                <!--slider sin funcion aun-->
                <!---->
                    <img id="image-header" style="width: 100%; height: auto" src="images/veraguas1.jpg"  />
                </div>

              <!-- div class="ui-grid-a migrid"> -->
                   <!-- <div class="ui-block-a" style=" text-align:center" >
                         <img id="icon-Image" style="width: 150px; height: 150px" src="images/icon2.png" />
                    </div>-->

                    <!-- <div class="ui-block-b"> -->
                        <?php 
                        if ( $estado_sesion === "SI") {
                            //el usuario en si esta loggeado... se le muestra el mensaje de bienvenida
                            //se comprueba si ha aparecido el mensaje popup oneshot
                           
                        echo '<div style="color:#6aba2f;" class="">
                        <h2>¡Bienvenido a </h2><h1>iFISC!</h1>
                        <h4>'.$_SESSION['logged_user'].'.</h4></div>';
                             
                        }else{
                             echo '
                        <div data-role="content">
                            <a href="local/sesion/login.php" data-role="button" >
                                Entrar
                            </a>
                            <a href="local/admin/usuario/new.php" data-role="button" >
                                Regístrate
                            </a>
                        </div>';
                        } ?>
                     
        <!--             </div>
				</div> -->
						
	<!--contenido_1-->

      <div data-role="content">
        <ul data-role="listview" data-divider-theme="a" data-inset="true">
             <?php 
        $display_array = $obj_display->getAllDisplays();
        while ($display = mysql_fetch_array($display_array)) {
             echo '<li data-icon="check"><a data-transition="fade" data-ajax="false" 
             rel="external" href="/ifisc/local/vistas/static.php?item='.$display['id'].'">'.$display['Nombre'].'</a></li>';
        }
         ?>
        </ul>
    </div>
    <?php 
include $path_absoluto ."model/class_publicacion.php";
include $path_absoluto ."model/class_categoria.php";
$thispublicacion = new publicacion;
$thiscategoria = new categoria;


       echo '<hr>';
    
       
    $lista = $thispublicacion->getultimaspublicaciones();
        echo '<div data-role="content">';


        if (mysql_num_rows($lista)!=0){
                echo '  <ul data-role="listview" data-divider-theme="b" data-inset="false">
                <li data-role="list-divider" role="heading">
                    Últimas Noticias!
                </li>';
        while($row = mysql_fetch_array($lista)){
                $categoria_id = $row['id_categoria'];
                $nombre = $thiscategoria->getCategoriaNombreById($categoria_id);
             
       
                echo ' <li data-theme="c">';
                echo '<a href="/ifisc/local/vistas/vmart.php?art='.$row['id'].'" data-ajax="false" rel="external " data-transition="slide">';
                     echo $row['Titulo'];  
                      echo '<p> Categoria: '.$nombre.'</p>';     
                       echo ' </a>';
                                 
                echo ' </li>';
                                       } //fin del while
                 echo '</ul>';
                                       }//fin del if
                                       else{

                                        // echo "<h5>no hay campos relacionados</h5>";
                                       }
        echo '</div>';
 
  

//-----------------------------------------------------------
?>    
<h1>Publicaciones por categoria</h1>  
 <div data-role="content">
        <ul data-role="listview" data-autodividers="true" data-filter="true" data-inset="true">
            <?php 
            $host_name=$_SERVER['HTTP_HOST'];
            //buscamos todas las categorias que sean estaticas

           

            $categorias_estaticas = $thiscategoria->getAllCategoriasDinamico();
            //iteramos sobre todos los resultados
            while ($categoria_simple = mysql_fetch_array($categorias_estaticas)) {
                echo '<li data-icon="check"><a data-ajax="false" data-rel="external" href="/ifisc/local/vistas/vmcategoria.php?categoria='.$categoria_simple['id'].'">'.$categoria_simple['Nombre'].'</a></li>';

            }
             ?>
        </ul>
        </div>  
        <h5> <?php echo '<div class="fb-send" data-href="'.$host_name.'ifisc/index.php" data-colorscheme="dark" data-font="verdana"> '?></div></h5>
             
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>

