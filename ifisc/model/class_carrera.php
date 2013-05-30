<?php 
    class carrera 
    {
        public function getCarreraNameById($carrera_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT Nombre FROM carrera c where c.id = '$carrera_id'";
          //variable que almacenará el nombre de la carrera
           mysql_query("SET NAMES 'utf8'");
           $carrera_name = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $carrera_name['Nombre'];         
        }
     }
 ?>