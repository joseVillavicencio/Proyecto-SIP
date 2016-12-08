<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();
	$producto=3;
	$coef=$_POST["c"];
	$prevision=0;
	$error=0;
	
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$sql32 = "call existenDatosME('".$producto."','".$coef."');";
			
		if($result32 = $conexion->query($sql32)){
				
			if($result32->num_rows >0){
					$conexion = conectar();
				$sql = "call mostrarME('".$producto."');";
				
				if($result2 = $conexion->query($sql)){
				
					if($result2->num_rows >0){
						
						while($fila = mysqli_fetch_row($result2)){
							$periodo= $fila[0];
							$demanda= $fila[1];
						}
					}
				}
			}
		}else{
			
			}
			
	}
	mysqli_close($conexion);
?>