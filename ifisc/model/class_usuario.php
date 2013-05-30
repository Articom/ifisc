<?php 
    class usuarioN 
    {
        public function getUsuarioById($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM usuario u where u.id = '$usuario_id'";
          //variable que almacenará los datos del usuario
           $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuarioBasico;         
        } 
         public function getUsuarioByName($usuario_name)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM usuario u where u.Nombre = '$usuario_name'";
          //variable que almacenará los datos del usuario
           $usuarioBasico = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuarioBasico;         
        } 
        public function getUsuarioByCorreo($usuario_correo)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT id FROM usuario u where u.mail = '$usuario_correo'";
          //variable que almacenará los datos del usuario
           $usuarioBasico = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuarioBasico;         
        } 
         public function getNombreUsuarioById($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT Nombre FROM usuario u where u.id = '$usuario_id'";
          //variable que almacenará los datos del usuario
           $usuarioName = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuarioName['Nombre'];         
        } 
      }
 ?>