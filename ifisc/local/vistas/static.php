<?php // filtro para mostrar los temas del menu
//iniciamos la sesion para utilizarla en todas las paginas

//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 
   //variable que indica la localizacion absoluta del archivo.
    $conection_file = $path_absoluto ."model/sesion/seguridad/open_conn.php";
  require $conection_file;
include $path_absoluto ."model/class_display.php";
if (isset($_GET['item'])) {
    //se busca los datos asociados a ese item
  $item_selected= $_GET['item'];
//se crea un objeto para accesar a los metodos de la clase
$obj_display = new displayes;
  //se buscan los datos de ese item
$display_array = $obj_display->getDisplayById($item_selected);
$display_tipo = mysql_fetch_assoc($display_array);
if ($display_tipo['id'] =="") {
  # mnostramos un error

}else{
  if ($display_tipo['isCategoria']) {
    # se incluye la vista para mostrar las categorias
     include $path_absoluto ."local/vistas/vmcategoria.php";
  }else{
    # es una publicacion, se incluye la vista para mostar una publicacion
      include $path_absoluto ."local/vistas/vmart.php";
  }
}

}else{
  // mensaje de error

}
 ?>
