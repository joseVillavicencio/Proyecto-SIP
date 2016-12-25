<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	$conexion = conectar();

	$prod=$_POST["p"];
	//$producto=3;
	$coef=$_POST["c"];
	$prevision=0;
	$error=0;
		
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$sql = "CALL buscarIdPro('".$prod."');";
		if($result = $conexion->query($sql)){
			if($result->num_rows >0){
				while($fila = mysqli_fetch_row($result)){
					$producto=$fila[0];
				}
					
				$conexion = conectar();
				$sqlr = "call reiniciarExponencial('".$producto."');";
				if($resultr = $conexion->query($sqlr)){
					echo "reinicio esta caga";
				}			
					
						
				$conexion = conectar();
				$sql = "call obtenerDatosIniciales('".$producto."');";
				
				if($result2 = $conexion->query($sql)){
				
					if($result2->num_rows >0){
						
						while($fila = mysqli_fetch_row($result2)){
							$periodo= $fila[0];
							$demanda= $fila[1];
							
						
							if($periodo==1){
								
								
								$conexion2 = conectar();
								$sql2 = "call insertarDatosMediaExponencial('".$producto."','".$prevision."','".$error."','".$periodo."','".$coef."');";
								if($result3 = $conexion2->query($sql2)){
									
									if($result3){
										$p=2;
										$conexion = conectar();
										$sql4 = "call insertarDemanda('".$producto."','".$demanda."','".$p."');";
										if($result4 = $conexion->query($sql4)){
											if($result4){
												$prevision=$demanda;
												
											}
											
											
										}	
									}
								}			
							}else{
								$periodo_anterior=$periodo-1;
								
								if($periodo==2){
									$error=$demanda-$prevision;
									
									$conexion = conectar();
									$sql = "call insertarError('".$producto."','".$periodo."','".$error."','".$coef."');"; // en este caso es un update xk como es el 2 ya esta creado
									if($result = $conexion->query($sql)){
										if($result){
											
										}
									}
								}else{
									
									$conexion = conectar();
									$sql5 = "call obtenerPronosticoAnterior('".$periodo_anterior."','".$producto."');";
									if($result = $conexion->query($sql5)){
										
										if($result->num_rows >0){
											while($fila = mysqli_fetch_row($result)){

												$demanda_ant= $fila[0];
												$prev= $fila[1];
											}
											$calcular=$prev+$coef*($demanda_ant-$prev);
											$error=$demanda-$calcular;
											
											
											$conexion = conectar();
											$sql = "call insertarDatosMediaExponencial('".$producto."','".$calcular."','".$error."','".$periodo."','".$coef."');";

											if($result = $conexion->query($sql)){
												if($result){
												
												
												}
											}
										}
									}	
								}
								
							}
						
						}
						
						$conexion = conectar();
						$sql5 = "call obtenerPronosticoAnterior('".$periodo."','".$producto."');";
						if($result = $conexion->query($sql5)){
							
							if($result->num_rows >0){
								while($fila = mysqli_fetch_row($result)){
									$demanda_ant= $fila[0];
									$prev= $fila[1];
								}
								$error=$demanda_ant-$prev;
								$calcular=$prev+$coef*($demanda_ant-$prev);
								
								$conexion = conectar();
								$periodo=$periodo+1;
								

								$sql = "call insertarDatosMediaExponencial('".$producto."','".$calcular."','".$error."','".$periodo."','".$coef."');";
								if($result = $conexion->query($sql)){
									if($result){
										
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