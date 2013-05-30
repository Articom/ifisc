<?php 
    class alerta 
    {
        public function getAlertaByUser($user_name)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta para buscar la alerta del usuario en uso
          $alerta_cons ="SELECT * FROM usuario u where u.Nombre = '$user_name'";
          //variable que almacenará el valor de la alerta

          mysql_query("SET NAMES 'utf8'");
          $alarta_user = mysql_query($alerta_cons,$conn); 
          $alerta = mysql_fetch_assoc($alarta_user);
          return $alerta['AlertaPendiente'];         
        }
        public function hideAlertByUsuario($user_name)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta para buscar la alerta del usuario en uso
          $alerta_cons ="UPDATE usuario SET AlertaPendiente = false WHERE Nombre = '$user_name'";
          //variable que almacenará el valor de la alerta

          mysql_query("SET NAMES 'utf8'");
          mysql_query($alerta_cons,$conn);   
        }
        
    }
 ?>