<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();
	
	$producto=2;
	$sumatoriaSemana=0;
	$sumatoriaSemana2=0;
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$sql = "call datosECL('".$producto."');";
		
		if($result = $conexion->query($sql)){
		
			if($result->num_rows >0){
				
				while($fila = mysqli_fetch_row($result)){
					$a= $fila[0];
					$b= $fila[1];
					$y= $a."+".$b."X";
					
					echo '<tr><td>'.$a.'</td><td>'.$b.'</td><td>'.$y.'</td><tr>';
				}
			}
		}
		
	}
	mysqli_close($conexion);
?>