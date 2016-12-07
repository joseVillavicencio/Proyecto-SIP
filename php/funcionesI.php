<?php
	
	function conectar(){
	$servidor= "localhost";
	$user= "root";
	$pass="";
	$BD="sip"; 
	$conexion= new mysqli($servidor,$user,$pass,$BD);
	return $conexion;
   }
 
?>