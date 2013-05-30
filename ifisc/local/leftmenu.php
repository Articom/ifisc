 <?php
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

$ssql2 ="SELECT * FROM display ";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $display_array = mysql_query($ssql2,$conn); 
?>
 <div data-role="panel" data-position-fixed="true" data-theme="a" id="nav-panel">

     <ul data-role="listview" data-theme="f" class="nav-search">
            <li data-icon="delete"><a href="#" data-rel="close">Cerra Menú</a></li>
        <?php 
        //$display_array = $obj_display->getAllDisplays();
        while ($display = mysql_fetch_array($display_array)) {
             echo '<li data-icon="check"><a data-transition="fade" data-ajax="false" 
             rel="external" href="/ifisc/local/vistas/static.php?item='.$display['id'].'">'.$display['Nombre'].'</a></li>';
        }
         ?>
        
        </ul>
    </div><!-- /panel -->