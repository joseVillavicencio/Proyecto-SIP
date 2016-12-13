<?php
	header('Content-Type: charset=utf-8');
	include('funcionesI.php');
	
	$conexion = conectar();
	$producto=$_POST["producto"];
	$stock_inicial=$_POST["stock_inicial"];
	$stock_final=$_POST["stock_final"]; // si es cero es porque no tiene restriccion. Sino insertar.
	$stock_medio=$_POST["stock_medio"];
	$atraso=$_POST["atraso"]; // es 1 si se permite postergar, 0 si es que no
	$min_normal=$_POST["min_normal"];
	$max_normal=$_POST["max_normal"];
	$normal_boolean=$_POST["normal_boolean"];
	$min_extra=$_POST["min_extra"];
	$m=$_POST["max_extra"];
	$e=$_POST["extra_boolean"];
	$min =$_POST["min_subc"];
	$max=$_POST["max_subc"];
	$sub=$_POST["subc_boolean"];
	$atraso=0;
	$n=1;
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
				$sql_cont = "call contarProducto('".$producto."');";
				if($result_cont = $conexion->query($sql_cont)){
					if($result_cont->num_rows >0){
						while($fila = mysqli_fetch_row($result_cont)){
							$cantidad=$fila[0];
						}
						while($valor<=$cantidad){
							if($valor==0){
								$conexion = conectar();
								$sql = "call actualizarPlaneacion('".$id."','".$n."','".$stock_inicial."','".$stock_final."','".$atraso."');";
						
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
												echo "Periodo".$periodo."<br>";
												echo $stock_inicial_actual;
													//echo "demanda".$demanda." ";
													//echo "ataso_actual".$atraso_actual;
												echo "<br>";
												$produccion_demanda=($pro_normal-$demanda);
												echo "Pro-DEM:".$produccion_demanda."<br>";
													
												$valor_stock_final=$stock_inicial_actual+$produccion_demanda;
												echo $stock_inicial_actual."+ ".$produccion_demanda." =";
												echo $valor_stock_final."<br>";
													
												$stock_medio=($stock_inicial_actual+$valor_stock_final)/2;
													if($stock_medio<0){
														echo "stock negativo<br>";
														$stock_medio=$stock_medio*-1;
													}
												$conexion = conectar();
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$atraso."');";
												
												if($result3 = $conexion->query($sql3)){
													if($result3){
														
														$uno=1;
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
										echo "Periodo".$periodo."<br>";
										echo $stock_inicial_actual;
										//echo "demanda".$demanda." ";
										//echo "ataso_actual".$atraso_actual;
										echo "<br>";
										
										$produccion_demanda=($pro_normal-$demanda);
										echo "Pro-DEM:".$produccion_demanda."<br>";
										
										$valor_stock_final=$stock_inicial_actual+$produccion_demanda;
										echo $stock_inicial_actual."+ ".$produccion_demanda." =";
										echo $valor_stock_final."<br>";
										
										$stock_medio=($stock_inicial_actual+$valor_stock_final)/2;
										if($stock_medio<0){
											echo "stock negativo<br>";
											$stock_medio=$stock_medio*-1;
										}
										if($atraso_actual==0){
											//if($produccion_$demanda>0){
											/*
											if($stock_inicial_actual==0 && $stock_final_actual==0){ // si no tengo stock inicial ni final y quede debiendo produccion
												echo "AQUIIIIIIIIIIIIIIIIIIII";
												$menos_uno=-1;
												$atraso= ($produccion_demanda)*$menos_uno;
												echo "atras".$atraso;
												$conexion = conectar();
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."',0,0,'".$atraso."');";
											
												if($result3 = $conexion->query($sql3)){
													if($result3){
													}
												}
											}*/
											
											$conexion = conectar();
											$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."','".$valor_stock_final."','".$stock_medio."','".$atraso."');";
											
											if($result3 = $conexion->query($sql3)){
												if($result3){
													
													$uno=1;
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
											echo "HAY ATTRASo <br>";
											if($stock_inicial_actual==0 && $stock_final_actual==0){ // si no tengo stock inicial ni final y quede debiendo produccion
												$atraso= ($produccion_demanda)*-1;
												echo "CASO ESPECIAL".$atraso." ";
												$conexion = conectar();
												$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."',0,0,'".$atraso."');";
											
												if($result3 = $conexion->query($sql3)){
													if($result3){
														$uno=1;
															$periodo_siguiente= $periodo + $uno;
															
															$conexion = conectar();
															$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."',0);"; // setear el final en el inicial del siguiente
															
															if($result4 = $conexion->query($sql4)){
																if($result4){
																
																}
															}	
													
													}
												}
											}else{
											
												$deuda=$produccion_demanda+$atraso_actual;
												if($deuda==0){
													$atraso= ($produccion_demanda)*-1;
													$conexion = conectar();
													$sql3 = "call actualizarStock('".$id."','".$periodo."','".$produccion_demanda."',0,0,0);"; // se paga la deuda
												
													if($result3 = $conexion->query($sql3)){
														if($result3){
															
															$uno=1;
															$periodo_siguiente= $periodo + $uno;
															
															$conexion = conectar();
															$sql4 = "call actualizarSiguiente('".$id."','".$periodo_siguiente."',0);"; // setear el final en el inicial del siguiente
															
															if($result4 = $conexion->query($sql4)){
																if($result4){
																
																}
															}	
															
														}
													}
												}else{
													echo "me falta esye cso";
												}
											}
										}
										$valor=$valor+1;
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