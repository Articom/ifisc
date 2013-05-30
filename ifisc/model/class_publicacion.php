<?php 
    class publicacion 
    {
        public function getAllPublicacionesByUsuarioName($nombre_usuario)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //buscamos el id del usuario segun el nombre de usuario introducido
          $ssql2 = "SELECT * FROM usuario u WHERE u.Nombre = '$nombre_usuario'";
          $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn));
          $usuario_id = $usuario['id'];
         $query = "SELECT * FROM publicacion p WHERE p.id_usuario = '$usuario_id'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publicaciones = mysql_query($query,$conn); 
          return $publicaciones;         
        } 

        public function getAllPublicacionesPendientes()
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM publicacion WHERE Estado = 2";
          //variable que almacenará las publicaciones pendientes
          mysql_query("SET NAMES 'utf8'");
          $publicaciones = mysql_query($ssql2,$conn); 
          return $publicaciones;         
        }

         public function getPublicacionesPendientesByUsuarioName($nombre_usuario)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //buscamos el id del usuario segun el nombre de usuario introducido
          $ssql2 = "SELECT * FROM usuario u WHERE u.Nombre = '$nombre_usuario'";
          $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn));
          $usuario_id = $usuario['id'];
         $query = "SELECT * FROM publicacion p WHERE p.id_usuario = '$usuario_id'
                    AND p.Estado = 2";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publicaciones = mysql_query($query,$conn); 
          return $publicaciones;         
        }

        public function getPublicacionesAprobadasByUsuarioName($nombre_usuario)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //buscamos el id del usuario segun el nombre de usuario introducido
          $ssql2 = "SELECT * FROM usuario u WHERE u.Nombre = '$nombre_usuario'";
          $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn));
          $usuario_id = $usuario['id'];
         $query = "SELECT * FROM publicacion p WHERE p.id_usuario = '$usuario_id'
                    AND p.Estado = 1";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publicaciones = mysql_query($query,$conn); 
          return $publicaciones;         
        }

        public function getPublicacionesEliminadasByUsuarioName($nombre_usuario)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //buscamos el id del usuario segun el nombre de usuario introducido
          $ssql2 = "SELECT * FROM usuario u WHERE u.Nombre = '$nombre_usuario'";
          $usuario = mysql_fetch_assoc(mysql_query($ssql2,$conn));
          $usuario_id = $usuario['id'];
         $query = "SELECT * FROM publicacion p WHERE p.id_usuario = '$usuario_id'
                    AND p.Estado = 3";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publicaciones = mysql_query($query,$conn); 
          return $publicaciones;         
        }   

         public function getPublicacionById($publicacion_id)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
         $query = "SELECT * FROM publicacion p WHERE p.id = '$publicacion_id'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_fetch_assoc(mysql_query($query,$conn)); 
          return $publication;         
        }   

         public function getIdCategoriasOfPublicacionesPendientes()
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta que me selecciona todos los id_categoria que tenga las publcaciones pendientes
         $query = "SELECT id_categoria FROM publicacion p where p.Estado = 2 GROUP BY id_categoria";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_query($query,$conn); 
          return $publication;         
        } 

         public function getPublicacionesPendientesByIdCategoria($categoria_id)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta que me selecciona todos los id_categoria que tenga las publcaciones pendientes
         $query = "SELECT * FROM publicacion p where p.Estado = 2 AND p.id_categoria = '$categoria_id'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publicationes = mysql_query($query,$conn); 
          return $publicationes;         
        } 

         public function getPublicacionIdByCodigo($codigo)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta que me seleciona la publicacion segun el codigo
         $query = "SELECT * FROM publicacion p where p.Codigo = '$codigo'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_fetch_assoc(mysql_query($query,$conn)); 
          return $publication['id'];         
        } 
        //obtiene el array de una categoria espesifica funcion de shino
        public function getPublicacionByCategoriaId($categoria_id)
        {
           //localizamos el archivo de coneccion
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
         $query = "SELECT * FROM publicacion p WHERE p.id_categoria = '$categoria_id'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_query($query,$conn); 
          return $publication;         
        } 
        //funciones de ovidio
        public function getPublicacionAprobadasByCategoriaId($categoria_id)
        {
           //localizamos el archivo de coneccion
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
         $query = "SELECT * FROM publicacion p WHERE p.id_categoria = '$categoria_id' AND Estado = '1'";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_query($query,$conn); 
          return $publication;         
        } 
         public function getCategoriasIdOfPublicacionesEstaticasAprobadas()
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //consulta que me selecciona todos los id_categoria que tenga las publcaciones Estaticas
         $query = "SELECT id_categoria FROM publicacion p WHERE p.id_categoria IN (SELECT id FROM categoria c WHERE c.isEstatico = true) AND p.Estado = '1' GROUP BY p.id_categoria";
          //variable que almacenará las categorias de el usuario
          mysql_query("SET NAMES 'utf8'");
          $categorias = mysql_query($query,$conn); 
          return $categorias;         
        }     
        public function getAllFechaModPublicacionesNuevas()
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //cONSULTA QUE SELECCIONA LAS FECHAS 6 DE LAS PUBLICACIONES APROBADAS 
         $query = "SELECT FechaMod FROM publicacion WHERE Estado = 1 and  id_categoria in 
         (select id from categoria where isEstatico =false) GROUP BY FechaMod ORDER 
         BY FechaMod DESC LIMIT 6";
          //variable que almacenará las categorias de el usuario
          mysql_query("SET NAMES 'utf8'");
          $fechas = mysql_query($query,$conn); 
          return $fechas;         
        }       
        public function getFechaModsPublicacionesNuevasByPreferenciasUsuarioName($usuario_name)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //cONSULTA QUE SELECCIONA LAS FECHAS 6 DE LAS PUBLICACIONES APROBADAS estaticas dependiendo lde las preferencias del usuario
         $query = "SELECT FechaMod from publicacion where Estado = 1 and
         id_categoria in(select id_categoria from preferencias where
         id_usuario in (Select id from usuario where Nombre = '$usuario_name') ) and  
          id_categoria in (select id from categoria where isEstatico =false)
         group by FechaMod order by FechaMod desc limit 6";
          //variable que almacenará las categorias de el usuario
          mysql_query("SET NAMES 'utf8'");
          $fechas = mysql_query($query,$conn); 
          return $fechas;         
        }
        public function getAllPublicacionesNuevasByFechaMod($fecha)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //cONSULTA QUE SELECCIONA LAS FECHAS 6 DE LAS PUBLICACIONES APROBADAS 
         $query = "SELECT * FROM publicacion WHERE Estado = 1 and 
          id_categoria in (select id from categoria where isEstatico =false)
           and FechaMod = '$fecha' ORDER BY FechaMod DESC LIMIT 6";
          //variable que almacenará las categorias de el usuario
          mysql_query("SET NAMES 'utf8'");
          $articulos = mysql_query($query,$conn); 
          return $articulos;         
        } 
        public function getultimaspublicaciones()
        {
           //localizamos el archivo de coneccion
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
         $query = "SELECT * FROM publicacion p where  p.id_categoria IN (select id from categoria where isEstatico = false) and p.Estado = 1 ORDER BY p.FechaMod Desc limit 6";
          //variable que almacenará las publicaciones de el usuario
          mysql_query("SET NAMES 'utf8'");
          $publication = mysql_query($query,$conn); 
          return $publication;         
        }      
        public function getPublicacionesNuevasByPreferenciasUsuarioNameAndFechaMod($usuario_name, $fecha)
        {
           //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          //cONSULTA QUE SELECCIONA LAS FECHAS 6 DE LAS PUBLICACIONES APROBADAS estaticas dependiendo lde las preferencias del usuario
         $query = "SELECT * from publicacion where Estado = 1 and
          id_categoria in(select id_categoria from preferencias where
          id_usuario in (Select id from usuario where Nombre = '$usuario_name') )
          and  id_categoria in (select id from categoria where isEstatico =false)
      and FechaMod = '$fecha'
          order by FechaMod desc limit 5;";
          //variable que almacenará las categorias de el usuario
          mysql_query("SET NAMES 'utf8'");
          $articulos = mysql_query($query,$conn); 
          return $articulos;         
        }                                        
    }
 ?>