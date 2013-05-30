<?php 
    class correl 
    {
        public function getCorrelativoValorByType($tipo_correlativo)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssql2 ="SELECT * FROM correlativo c WHERE c.Tipo = '$tipo_correlativo'";
          //variable que almacenará el numero de correlativo
          mysql_query("SET NAMES 'utf8'");
          $correlativo = mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
          return $correlativo['Valor'];         
        }

        public function UpdateCorrelativoByTipe($tipo_correlativo)
        {
          //localizamos el archivo de coneccion
                  
          include "sesion/seguridad/open_conn.php";
          $conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
          mysql_select_db("$db_name")or die("cannot select DB");
          //comprobamos la conección de la base de datos
          $ssqlselect ="SELECT Valor FROM correlativo c WHERE c.Tipo ='$tipo_correlativo'";
          //se ejecuta la consultra que tra el numero de correlativo actual
          $correlativo = mysql_fetch_assoc(mysql_query($ssqlselect,$conn));
          $numeroCorrelativo = $correlativo['Valor'];
          //se le suma uno al correlativo
          $numeroCorrelativo++;
          //se guarda el valor nuevo a la base de datos 
          $ssqlUpdate ="UPDATE correlativo SET Valor = '$numeroCorrelativo' WHERE Tipo = '$tipo_correlativo'";
          //se ejecuta la consulta
          mysql_query($ssqlUpdate,$conn); 
        } 
    }
 ?>