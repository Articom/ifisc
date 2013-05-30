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
$titulo = "";
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
<div>
<?php 
include $path_absoluto ."model/class_publicacion.php";
include $path_absoluto ."model/class_categoria.php";
$thispublicacion = new publicacion;
$thiscategoria = new categoria;

if (isset($_GET['ar'])){ 
  $id_publicacion = $_GET['ar'];
        $contenido_publicacion = $thispublicacion->getPublicacionById($id_publicacion);
echo '<div id="hoja">';
print '<div id="op"><a href="#"> <img id="image-header" style="width: 40px; height: 10px" src=""  />...</a></div>';
       echo 'el ide de la publicacion es'.$id_publicacion;
        echo "<h2> ".$contenido_publicacion['Titulo'] ."</h2>";
       echo '<div class="conten_publicacion">';
        echo $contenido_publicacion['Cuerpo'];
        echo '</div></div>';
        ?>
    <div class="articles_nav">
        <span class="prev_article"><a href="" rel="prev"><span>‹</span> Anterior</a></span>
        <span class="next_article"><a href="" rel="next">Siguiente <span>›</span></a> </span>
    </div>

        <?php
        
        $categoria_id = $contenido_publicacion['id_categoria'];
        $nombre = $thiscategoria->getCategoriaNombreById($categoria_id);
       echo '<div id="seccion">';
        echo "<h5>publicaciones relacionadas con: ".$nombre." </h5></div>";
       
        $lista = $thispublicacion->getPublicacionByCategoriaId($categoria_id);
        echo '<div data-role="collapsible" data-theme="b" data-content-theme="c">';
        echo '<h4>Publicaciones relacionadas</h4>';
        if (mysql_num_rows($lista)!=0){
           echo '<ul data-role="listview" data-divider-theme="a" data-inset="true">';
        while($row = mysql_fetch_array($lista)){
                 echo '<li data-theme="c"><a href="/ifisc/local/vistas/public.php?ar='.$row['id'].'" rel="external" data-transition="slide">';
                     echo $row['Titulo'];     
                       echo ' </a></li>';
                                       } //fin del while
         echo '</ul>';
                                       }//fin del if
                                       else{

                                        echo "<h5>no hay campos relacionados</h5>";
                                       }
        echo '</div>';
}    
else{echo "<h1>La publicacion no existe, o fue removida!</h1>";
}   

//-----------------------------------------------------------
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
