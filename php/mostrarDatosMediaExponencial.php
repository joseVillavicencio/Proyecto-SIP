<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();
	$pronostico=1;
	$producto=1;
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$sql = "call obtenerProMediaExp('".$pronostico."','".$producto."');";
		
		if($result = $conexion->query($sql)){
		
			if($result->num_rows >0){
				
				while($fila = mysqli_fetch_row($result)){
					$n= $fila[0];
					$demanda= $fila[1];
					$prevision= $fila[2];
					$error= $fila[3];
					echo '<tr><td>'.$n.'</td><td>'.$demanda.'</td><td>'.$prevision.'</td><td>'.$error.'</td></tr>';
				}
			}
		}
		
	}
	mysqli_close($conexion);
?>