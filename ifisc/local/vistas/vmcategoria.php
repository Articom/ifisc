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


<?php 
if(isset($_GET['categoria']) || isset($item_selected)){
    if (isset($_GET['categoria'])) {
        //la variable fue por el ger
        $categoria_id = $_GET['categoria'];
    }//la variable viene externamente
    else{
        $categoria_id = $item_selected;
    }
include $path_absoluto.'model/class_publicacion.php';
$thispublicacion= new publicacion;
$lista_publicacion = $thispublicacion->getPublicacionAprobadasByCategoriaId($categoria_id);
if(mysql_fetch_row($lista_publicacion) != 0){
    //desplegamos la lista de articulos.
echo '<ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
         CATEGORIA
            </li>';

while ($fila = mysql_fetch_array($lista_publicacion)) {
 echo '<li data-theme="c">
                <a href="/ifisc/local/vistas/vmart.php?art=';
                echo $fila['id'];
                echo '" rel="external" data-ajax="false" data-transition="slide">';
                echo $fila['Titulo'];
                    
                  echo '</a><div class="vmcontent"><p>';
                   echo substr($fila['Cuerpo'],0,50);
                  echo '</p></div>
                </li>';
    
    }//fin del while
echo " </ul>";
}//fin del if
else{echo '<div class="bar">
    <h1>¡No se han registrado publicaciones para esta categoría!</h1>
    <p></p><h4>De seguro en otras categorías encontrás artículos de tu interés.<h4></div>';
    }//finelse
?>
       

<?php

 }else{

echo '<div class="bar"><h1>¡Oops! ¡Lo sentimos, lo que buscas, no esta aquí!</h1></div>';

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


 <!-- referencias 
<div class="herra_ultimos"><div style="clear:both;"><img src="../../../../modules/portal/images/clear.gif" height="1" width="1" alt="clear"></div><div class="herra_ultimos_mod"><a href="../../../../index.php?action=portal/viewContent&amp;cntId_content=25626"><div class="herra_ultimos_fotos"><img alt="iWatch: el reloj inteligente de Apple se retrasa" src="../../../../resources/produccion/contenidos/small/---20124/applewatchnano657.jpg" width="112" height="73" border="0"></div><div class="herra_ultimos_texto"><span class="destacado_tit_rojo">iWatch: </span>el reloj inteligente de <span class="destacado_tit_rojo">Apple </span>se retrasa </div><div style="clear:both;"><img src="../../../../modules/portal/imagenes/clear.gif" height="1" width="1" alt="clear"></div></a></div><div class="herra_ultimos_mod"><a href="../../../../index.php?action=portal/viewContent&amp;cntId_content=25621"><div class="herra_ultimos_fotos"><img alt="Motorola trae a Argentina los nuevos RAZR D3 y D1 y apuesta a la TV digital" src="../../../../resources/produccion/contenidos/small/IN_2013/-tecno/motod1d31657.jpg" width="112" height="73" border="0"></div><div class="herra_ultimos_texto"><span class="destacado_tit_rojo">Motorola </span>trae a Argentina los nuevos <span class="destacado_tit_rojo">RAZR D3 y D1 </span>y apuesta a la TV digital </div><div style="clear:both;"><img src="../../../../modules/portal/imagenes/clear.gif" height="1" width="1" alt="clear"></div></a></div><div class="herra_ultimos_mod"><a href="../../../../index.php?action=portal/viewContent&amp;cntId_content=25614"><div class="herra_ultimos_fotos"><img alt="Google y Microsoft finalmente trabajarán juntas ¿en qué?" src="../../../../resources/produccion/contenidos/small/IN_2013/-tecno/microsoftgoogle657.jpg" width="112" height="73" border="0"></div><div class="herra_ultimos_texto"><span class="destacado_tit_rojo">Google </span>y <span class="destacado_tit_rojo">Microsoft </span>finalmente trabajarán juntas ¿en qué? </div><div style="clear:both;"><img src="../../../../modules/portal/imagenes/clear.gif" height="1" width="1" alt="clear"></div></a></div><div class="herra_ultimos_mod"><a href="../../../../index.php?action=portal/viewContent&amp;cntId_content=25605"><div class="herra_ultimos_fotos"><img alt="El botón inicio de Windows 8 llega al mouse" src="../../../../resources/produccion/contenidos/small/IN_2013/-tecno/windows8mouseclose657.jpg" width="112" height="73" border="0"></div><div class="herra_ultimos_texto">El botón inicio de <span class="destacado_tit_rojo">Windows 8 </span>llega al mouse </div><div style="clear:both;"><img src="../../../../modules/portal/imagenes/clear.gif" height="1" width="1" alt="clear"></div></a></div><div class="herra_ultimos_mod"><a href="../../../../index.php?action=portal/viewContent&amp;cntId_content=25607"><div class="herra_ultimos_fotos"><img alt="Confirmado: Samsung Galaxy S4 llega a Argentina en junio" src="../../../../resources/produccion/contenidos/small/IN_2013/-tecno/sgs4colores657.jpg" width="112" height="73" border="0"></div><div class="herra_ultimos_texto">Confirmado: <span class="destacado_tit_rojo">Samsung Galaxy S4 </span>llega a Argentina en junio </div><div style="clear:both;"><img src="../../../../modules/portal/imagenes/clear.gif" height="1" width="1" alt="clear"></div></a></div></div>      
         
  fin referencias-->     