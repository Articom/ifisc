<?php 
    class role 
    {
        public function getNombreRoleById($role_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT Nombre FROM role r where r.id = '$role_id'";
          //variable que almacenará el nombre de role
           mysql_query("SET NAMES 'utf8'");
          $role = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $role['Nombre'];         
        } 
        public function getAllRole()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM role ";
          //variable que almacenará el nombre de role
           mysql_query("SET NAMES 'utf8'");
          $roles = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $roles;         
        } 
    }
 ?>