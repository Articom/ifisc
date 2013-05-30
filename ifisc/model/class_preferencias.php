<?php 
    class preferencias 
    {
      //funcion que me busca todas las categorias que estan dentro de las preferencias de
      //usuario y ademas no son estaticas
      public function getIdCategoriasPreferenciasSelectedByIdUsuario($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE id IN 
                    (SELECT id_categoria FROM preferencias WHERE id_usuario = '$usuario_id'
                     ) AND isEstatico = false";
          //variable que almacenará el id de las categorias
          mysql_query("SET NAMES 'utf8'");
          $categorias_selected = mysql_query($ssql2,$conn);
          return $categorias_selected;         
      }
      //funcion que me busca todas las categorias que estan dentro de las preferencias de
      //usuario y son de cualquier tipo
      public function getAllIdCategoriasPreferenciasSelectedByIdUsuario($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE id IN 
                    (SELECT id_categoria FROM preferencias WHERE id_usuario = '$usuario_id')";
          //variable que almacenará el id de las categorias
          mysql_query("SET NAMES 'utf8'");
          $categorias_selected = mysql_query($ssql2,$conn);
          return $categorias_selected;         
      }
      //funcion que me busca todas las categorias que no estan dentro de las preferencias de
      //usuario y ademas no son estaticas
      public function getIdCategoriasPreferenciasNoSelectedByIdUsuario($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE id NOT IN 
                    (SELECT id_categoria FROM preferencias WHERE id_usuario = '$usuario_id'
                      ) AND isEstatico = false";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias_no_selected = mysql_query($ssql2,$conn);

          return $categorias_no_selected;         
      }
      //funcion que me busca todas las categorias que no estan dentro de las preferencias de
      //usuario y son de cualquier tipo
      public function getAllIdCategoriasPreferenciasNoSelectedByIdUsuario($usuario_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE id NOT IN 
                    (SELECT id_categoria FROM preferencias WHERE id_usuario = '$usuario_id')";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias_no_selected = mysql_query($ssql2,$conn);

          return $categorias_no_selected;         
      }
   }
 ?>