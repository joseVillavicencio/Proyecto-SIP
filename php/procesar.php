<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		/*
		if($result = $conexion->query($sql)){
			if($result->num_rows >0){
				while($fila = mysqli_fetch_row($result)){
					$idClub= $fila[0];
				}
				$conexion=conectar();
				$consulta2= "call aceptarPublic2('".$idP."','".$idClub."');";
				if($registro4 =$conexion->query($consulta2)){
					if($registro4){
						echo "1"; 
					}
				}
			}
		}
		
	}*/
		$periodo=$_POST['periodo'];
		$demanda=$_POST['demanda'];
		$ref=1;
		$i=0;
		$numero=count($demanda);
		echo $numero;
		for ($i=0; $i<=count($demanda); $i++) {	
			echo $periodo[$i].'<br>';
			echo $demanda[$i].'<br>';
			$sql = "call insertarPeriodo('".$periodo[$i]."','".$demanda[$i]."',1);";
			if($result = $conexion->query($sql)){
				if($result){
					echo "ok";
				}
			}
		}
	}
	mysqli_close($conexion);
?>