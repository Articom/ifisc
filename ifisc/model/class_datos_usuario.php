<?php 
    class datos_usuario 
    {
        public function getDatosDeUsuarioById($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM datosusuario d where d.id_usuario = '$usuario_id'";
          //variable que almacenará los datos del usuario
           $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuario;         
        } 
        public function getDatosDeUsuarioByCedula($usuario_cedula)
        {
          //localizamos el archivo de coneccion                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM datosusuario d where d.Cedula = '$usuario_cedula'";
          //variable que almacenará los datos del usuario
           $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $usuario;         
        } 
        public function getCodigoUsuarioByIdUsuario($usuario_id)
        {
          //localizamos el archivo de coneccion                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT Codigo FROM datosusuario d where d.id_usuario = '$usuario_id'";
          //variable que almacenará los datos del usuario
           $codigo = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $codigo['Codigo'];         
        } 
    }
 ?>