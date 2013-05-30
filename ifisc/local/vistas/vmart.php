
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
<?php 
if(isset($_GET['art']) || isset($item_selected)){
    if (isset($_GET['art'])) {
        //la variable fue por el ger
        $id_publicacion = $_GET['art'];
    }//la variable viene externamente
    else{
        $id_publicacion = $item_selected;
    }
include $path_absoluto ."model/class_publicacion.php";
include $path_absoluto ."model/class_categoria.php";
include $path_absoluto ."model/class_usuario.php";
$thispublicacion = new publicacion;
$thiscategoria = new categoria;
$thisUsuario = new usuarioN;

$publicacions = $thispublicacion->getPublicacionById($id_publicacion);
if (!$publicacions['id']=='') {


$categoria_id = $publicacions['id_categoria'];
$nombre_catg = $thiscategoria->getCategoriaNombreById($categoria_id);
?>

 <div class="caja_ar ">
        <div class="art_item">
            <div class="contenedor" data-role="content">
                <h1><?php echo $publicacions['Titulo'];?></h1>
                <div class="creado"><span>Publicado por <a <?php echo 'href="/ifisc/local/usuario/perfil.php?user='.$thisUsuario->getNombreUsuarioById($publicacions['id_usuario']).'" rel="external">';  ?>
                    <?php echo $thisUsuario->getNombreUsuarioById($publicacions['id_usuario']);?></a> el <?php echo $publicacions['FechaMod']; ?></span></div>
                <hr>
                <div class="descripcion">
                    <div><?php echo $publicacions['Cuerpo']?></div>

                </div>

                <div class="itemcategoria">Categoría de <a rel="external" <?php echo 'href="/ifisc/local/vistas/vmcategoria.php?categoria='.$categoria_id.'"'; ?> ><?php echo $nombre_catg; ?></a></div>
                <div class="compartir"> 
                    <a href="#" rel="external" class="  f">F</a>
                    <a href="#" rel="external" class="t"> T </a>
                    <a href="#" rel="external" class="cor">Cor</a>
                </div>

            </div>
        </div>
        <?php
        
        $categoria_id = $publicacions['id_categoria'];
        $nombre = $thiscategoria->getCategoriaNombreById($categoria_id);
       // echo '<div id="seccion">';
       //  echo "<h5>publicaciones relacionadas con: ".$nombre." </h5></div>";
        $lista = $thispublicacion->getPublicacionByCategoriaId($categoria_id);
        echo '<div data-role="collapsible" data-theme="b" data-content-theme="c">';
        echo '<h4>Publicaciones relacionadas</h4>';
        if (mysql_num_rows($lista)!=0){
            echo '<ul data-role="listview" data-divider-theme="a" data-inset="true">';
            while($row = mysql_fetch_array($lista)){
                echo '<li data-theme="c"><a href="/ifisc/local/vistas/vmart.php?art='.$row['id'].'" rel="external" data-transition="slide">';
                echo $row['Titulo'];     
                echo ' </a></li>';
            } //fin del while
            echo '</ul>';
            echo '</div>';
        }
?>


</div>


<?php
}//comprabacion de que hai un indice de articulo    
else{echo '<div class="bar">
    <h1>¡Esta publicación no existe o fue removida!</h1>
    <p></p><h4>De seguro en otras categorías encontrás artículos de tu interés.<h4></div>';
}
}

//comprabacion de que hai un indice de articulo    
else{echo '<div class="bar">
    <h1>¡Esta publicación no existe o fue removida!</h1>
    <p></p><h4>De seguro en otras categorías encontrás artículos de tu interés.<h4></div>';
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
