<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	
	$conexion = conectar();
	$producto=$_POST["producto"];
	$stock_inicial=$_POST["stock_inicial"];
	$stock_final_variable=$_POST["stock_final"]; // si es cero es porque no tiene restriccion. Sino insertar.
	$stock_medio_variable=$_POST["stock_medio"]; // es 0 si no tiene restriccion, tiene un valor si es que tiene
	$atraso_variable=$_POST["atraso"]; // es 1 si se permite postergar, 0 si es que no
	$min_normal=$_POST["min_normal"];
	$max_normal=$_POST["max_normal"];
	$normal_boolean=$_POST["normal_boolean"]; // es 1 si es cte es 0 sino 
	$min_extra=$_POST["min_extra"];
	$max_extra=$_POST["max_extra"];
	$min_subc =$_POST["min_subc"];
	$max_subc=$_POST["max_subc"];
	$stock_medio_final=$_POST["stock_medio_final"]; // es 0 si no tiene restriccion, tiene un valor si es que tiene
	$atraso=0;
	$uno=1;
	$valor=1;
	
	
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$conexion = conectar();
		$sqll = "call buscarIdPro('".$producto."');";
		if($resultt = $conexion->query($sqll)){
			if($resultt->num_rows >0){
				while($fila = mysqli_fetch_row($resultt)){
					$id=$fila[0];
				}
				$conexion = conectar();
				$sql_cont = "call contarProducto('".$id."');";
				if($result_cont = $conexion->query($sql_cont)){
					if($result_cont->num_rows >0){
						while($fila = mysqli_fetch_row($result_cont)){
							$cantidad=$fila[0];
						}
						while($valor<=$cantidad){
							if($valor==1){
								$conexion = conectar();
								$sql = "call actualizarPlaneacion('".$id."','".$valor."','".$stock_inicial."','".$stock_final_variable."',0);";
								if($result = $conexion->query($sql)){
									if($result){
										$conexion = conectar();
										$sql2 = "call obtenerPlaneacion('".$id."','".$valor."');";
										if($result2 = $conexion->query($sql2)){
											if($result2->num_rows >0){
												while($fila = mysqli_fetch_row($result2)){
													$periodo=$fila[0];
													$demanda=$fila[1];
													$pro_normal=$fila[2];
													$pro_extra=$fila[3];
													$pro_subc=$fila[4];
													$atraso_actual=$fila[5];
													$stock_inicial_actual=$fila[6];
													$stock_final_actual=$fila[7];
												}												
												if($normal_boolean==1){ 
													$produccion_comparar=$pro_normal; // seteo la produccion normal para comparar dsp
												}
												$produccion_demanda=(($pro_normal+$pro_extra+$pro_subc)-$demanda);
												
												if($stock_medio_variable!=0){
													$algo=$produccion_demanda-$stock_medio_variable;
													if($algo<$stock_medio_variable){ // si es menor al stock que tenemos que mantener
														$valor_stock_final=$stock_medio_variable; //seteamos el stock que tenemos que mantener
														$stock_medio=$stock_medio_variable;
														$atraso_actual=$produccion_demanda;
													}
												}else{
													$valor_stock_final=$stock_inicial_actual+$produccion_demanda;
													$stock_medio=($stock_inicial_actual+$valor_stock_final)/2;
												}
												if($stock_medio<0){
													$stock_medio=$stock_medio*-1;
												}
												$conexion = conectar();
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$atraso_actual."');";
												if($result3 = $conexion->query($sql3)){
													if($result3){
														$periodo_siguiente= $periodo + $uno;
														$conexion = conectar();
														$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."','".$valor_stock_final."');"; // setear el final en el inicial del siguiente
														if($result4 = $conexion->query($sql4)){
															if($result4){
																$valor=$valor+1;
															}
														}	
														
													}
												}
												
											}
										}
									}
								}										
							}else{
								$conexion = conectar();
								$sql2 = "call obtenerPlaneacion('".$id."','".$valor."');";
								if($result2 = $conexion->query($sql2)){
									if($result2->num_rows >0){
										while($fila = mysqli_fetch_row($result2)){
											$periodo=$fila[0];
											$demanda=$fila[1];
											$pro_normal=$fila[2];
											$pro_extra=$fila[3];
											$pro_subc=$fila[4];
											$atraso_actual=$fila[5];
											$stock_inicial_actual=$fila[6];
											$stock_final_actual=$fila[7];
										}										
										$per=$valor-$uno;
										$conexion = conectar();
										$sql_atraso = "CALL hayAtrasoAnterior('".$id."','".$per."');";
										if($result_atraso = $conexion->query($sql_atraso)){
											if($result_atraso->num_rows >0){
												while($fila2 = mysqli_fetch_row($result_atraso)){
													$atraso_pendiente=$fila2[0];
													
												}
											}
										}
										$produccion_demanda=(($pro_normal+$pro_extra+$pro_subc)-$demanda);
										$valor_stock_final=$stock_inicial_actual+$produccion_demanda;
										$stock_medio=($stock_inicial_actual+$valor_stock_final)/2;
										
										if($stock_medio<0){
											$stock_medio=$stock_medio*-1;
										}
										if($atraso_pendiente==0){
											if($stock_medio_variable!=0){
													$algo=$produccion_demanda-$stock_medio_variable;
													if($algo<$stock_medio_variable){ // si es menor al stock que tenemos que mantener
														$valor_stock_final=$stock_medio_variable; //seteamos el stock que tenemos que mantener
														$stock_medio=$stock_medio_variable;
														$atraso_actual=$produccion_demanda;
													}
											}else{
												if($valor_stock_final<0 ){
													$valor_stock_final=0;
													$stock_medio=0;
													$atraso_actual=$produccion_demanda;
												}
											}
											$conexion = conectar();
											$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$atraso_actual."');";
											if($result3 = $conexion->query($sql3)){
												if($result3){
													$periodo_siguiente= $periodo + $uno;
													$conexion = conectar();
													$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."','".$valor_stock_final."');"; // setear el final en el inicial del siguiente
													if($result4 = $conexion->query($sql4)){
														if($result4){
															
														}
													}	
													
												}
											}
										}else{
											$deuda=$produccion_demanda+$atraso_pendiente;
										
											if($deuda==0){
											//	echo "puedo pagarla<br>";
												$conexion = conectar();
												$valor_stock_final=$stock_medio_variable;
												if($stock_medio_variable==0){
													$stock_medio=0;
												}else{
													$stock_medio=$stock_medio_variable;
												}
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$deuda."');"; // se paga la deuda
												if($result3 = $conexion->query($sql3)){
													if($result3){
														$periodo_siguiente= $periodo + $uno;
														$conexion = conectar();
														$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."','".$valor_stock_final."');"; // setear el final en el inicial del siguiente
														
														if($result4 = $conexion->query($sql4)){
															if($result4){
															}
														}	
													}
												}
											}else{
												// si no puedo saldar la deuda , tengo que marcar el atraso
												$atraso_actual=$deuda;
												$conexion = conectar();
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$atraso_actual."');";
												if($result3 = $conexion->query($sql3)){
													if($result3){
														//echo "Caso en que no se saldó<br>";
														$periodo_siguiente= $periodo + $uno;
														$conexion = conectar();
														$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."','".$valor_stock_final."');"; // setear el final en el inicial del siguiente
														
														if($result4 = $conexion->query($sql4)){
															if($result4){
															}
														}	
													}
												}
											}
										}
										$valor=$valor+1;
									}	
								}
										
							}			
						}
						echo 1;
					}
				}
			}	
		}
		
	}	
	mysqli_close($conexion);	
?>