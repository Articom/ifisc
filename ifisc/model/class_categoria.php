<?php 
    class categoria 
    {
        public function getAllNombreCategoriaPublicas()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria c WHERE c.isEstatico = false";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_query($ssql2,$conn); 
          return $categorias;         
        }

        public function getAllNombreCategoria()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_query($ssql2,$conn); 
          return $categorias;         
        } 

        public function getCategoriaNombreById($categoria_id)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT Nombre FROM categoria WHERE id = '$categoria_id'";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          $categoriaNombre = $categorias['Nombre'];
          return $categoriaNombre;         
        }
        //busca todas las categorias que son estaticas
        public function getAllCategoriasEstaticas()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE isEstatico = true";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_query($ssql2,$conn); 
          return $categorias;         
        }
        public function getAllCategoriasDinamico()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM categoria WHERE isEstatico = false";
          //variable que almacenará el nombre de role
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_query($ssql2,$conn); 
          return $categorias;         
        }
    }
 ?>