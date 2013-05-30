<?php

		$host="localhost"; // Host name 
		$username="adminifisc"; // Mysql username 
		$password="junysan"; // Mysql password 
		$db_name="adminifisc"; // Database name 
		/*establesemos las funciones para la coneccion a la base  de datos*/
		$conn = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
		mysql_select_db("$db_name")or die("cannot select DB");
		//comprobamos la conección de la base de datos
		if (!$conn) {
			die('No se puede conectar: ' . mysql_error());
		}
		//para evitar que las tildes las formatee en otro formato
		mysql_query("SET NAMES 'utf8'");
 ?>