<?php 
    class displayes 
    {
        public function getAllDisplays()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM display";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $displaye = mysql_query($ssql2,$conn); 
          return $displaye;         
        }
        public function getDisplayById($display_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM display where id = '$display_id'";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $displaye = mysql_query($ssql2,$conn); 
          return $displaye;         
        }
        
    }
 ?>