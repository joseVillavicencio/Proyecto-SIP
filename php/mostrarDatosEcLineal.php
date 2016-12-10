<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();
	//$producto=$_POST["p"];
	$producto=2;
	$sumatoriaSemana=0;
	$sumatoriaSemana2=0;
	$sumatoriaY=0;
	$sumatoriaXY=0;
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$sql2 = "call contarN('".$producto."');";
		
		if($result2 = $conexion->query($sql2)){
			if($result2->num_rows >0){
				while($fila = mysqli_fetch_row($result2)){
					$n=$fila[0];
				}
				$conexion = conectar();
				$sql = "call obtenerDatosIniciales('".$producto."');";
			
				if($result = $conexion->query($sql)){
					if($result->num_rows >0){
					
						while($fila = mysqli_fetch_row($result)){
							$x=$fila[0];
							
							$demanda=$fila[1];
							$sumatoriaSemana=$x+$sumatoriaSemana;
							$sumatoriaY=$demanda+$sumatoriaY;
							$sumatoriaSemana2=$sumatoriaSemana2+ pow($x,2);
							$xy=$x*$demanda;
							$sumatoriaXY=$xy+$sumatoriaXY;
							echo '<tr class="odd"><td>'.$x.'</td><td>'.$demanda.'</td><td>'.$sumatoriaSemana.'</td><td>'.$sumatoriaSemana2.'</td><td>'.$xy.'</td></tr>';
						}
						$b_numerador= (($n*($sumatoriaXY))-($sumatoriaSemana*$sumatoriaY));
						$b_denominador=(($n*$sumatoriaSemana2)- pow($sumatoriaSemana,2));
						$b=$b_numerador/$b_denominador;
						$a= (($sumatoriaY)-($b*$sumatoriaSemana))/$n;
						
						$conexion = conectar();
						$sqlAB = "call consultarAB('".$producto."','".$a."','".$b."');";
						if($resultAB = $conexion->query($sqlAB)){
							if($resultAB->num_rows >0){
							}else{
								echo "aqui";
								$conexion = conectar();
								$sql2 = "call insertarAB('".$producto."','".$a."','".$b."','".$x."');";
								if($result2 = $conexion->query($sql2)){
									if($result2){
										
									}
								}
							}
						}
						
					}
				}		
			}			
		
		}
		
	}
	mysqli_close($conexion);
?>