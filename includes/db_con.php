<?php

	$enlace =new mysqli($DB_SERVER, $DB_USER, $DB_PASS,$DB_NAME);
	if($enlace->connect_error){
	  die("conexion fallida: ".$enlace->connect_error);
	}
	
	
//verificamos la conexxion


