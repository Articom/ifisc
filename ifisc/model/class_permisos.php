<?php 
    class permiso 
    {
        public function getPermisosByRoleName($role_name)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //buscamos el id del permiso por el nombre del rol
          $ssql2 ="SELECT id_permiso FROM role r where r.Nombre = '$role_name'";
          //variable que almacenará el id del permiso
          $roles = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          $permiso_id = $roles['id_permiso'];
          //buscanmos los permisos por el id de permiso
          $ssql ="SELECT * FROM permisos p where p.id = '$permiso_id'";
          $permisos = mysql_query($ssql,$conn);
          return $permisos;         
        }         
    }
 ?>