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
	$cantidad=1;
	$valor2=1;
	$cn=$_POST["cn"];
	$ce=$_POST["ce"];
	$cs=$_POST["cs"];
	$costo_atraso=$_POST["costo_atraso"];
	$costo_stock=$_POST["costo_stock"];
	$suma_plan=0;
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
				}
			}	
		}
	}	
	while($valor2<=$cantidad){
		$conexion = conectar();
		$sqlF = "call obtenerPlaneacionFinal('".$id."','".$valor2."');";
		if($resultF = $conexion->query($sqlF)){
			if($resultF->num_rows >0){
				while($fila = mysqli_fetch_row($resultF)){
					$periodo=$fila[0];
					$pro_normal=$fila[2];
					$pro_extra=$fila[3];
					$pro_subc=$fila[4];
					$atraso_actual=$fila[5];
					$stock_medio_actual=$fila[8];
					if($pro_normal!=0){
						$conexion = conectar();
						$cn2=$pro_normal*$cn;
						$costo_stock2=$costo_stock*$stock_medio_actual;
						$sql_n = "call actualizarCostoNormal('".$id."','".$periodo."','".$cn2."','".$costo_stock2."');";
						if($result_n = $conexion->query($sql_n)){
							if($result_n){
							}
						}	
					}
					if($pro_extra!=0){
						$conexion = conectar();
						$ce2=$ce*$pro_extra;
						$sql_e = "call actualizarCostoExtra('".$id."','".$periodo."','".$ce2."');";
						if($result_e = $conexion->query($sql_e)){
							if($result_e){
							}
						}
					}	
					if($pro_subc!=0){
						$conexion = conectar();
						$cs2=$cs*$pro_subc;
						$sql_s = "call actualizarCostoSubc('".$id."','".$periodo."','".$cs2."');";
						if($result_s = $conexion->query($sql_s)){
							if($result_s){
							}
						}	
					}	
						if($atraso_actual!=0){
							$conexion = conectar();
							$atraso_actual=$atraso_actual*-1;
							$costo_atraso2= $costo_atraso*$atraso_actual;
							$sql_a = "call actualizarAtraso('".$id."','".$periodo."','".$costo_atraso2."');";
							if($result_a = $conexion->query($sql_a)){
								if($result_a){
								}
							}	
						}	
					
				}
				$valor2=$valor2+1;
			}
		}
	}		
	$valor2=1;
		while($valor2<=$cantidad){
			$conexion = conectar();
			$sqlF = "call obtenerPlaneacionFinal('".$id."','".$valor2."');";
			if($resultF = $conexion->query($sqlF)){
				if($resultF->num_rows >0){
					while($fila = mysqli_fetch_row($resultF)){
						$periodo=$fila[0];
						$demanda=$fila[1];
						$pro_normal=$fila[2];
						$pro_extra=$fila[3];
						$pro_subc=$fila[4];
						$atraso_actual=$fila[5];
						$stock_inicial_actual=$fila[6];
						$stock_final_actual=$fila[7];
						$stock_medio_actual=$fila[8];
						$pro_dem=$fila[9];
						$costo_normal=$fila[10];
						$costo_extra=$fila[11];
						$costo_subc=$fila[12];
						$costo_stock=$fila[13];
						$costo_atraso=$fila[14];
					}
					$produccion_comparar=$pro_normal;
					$suma_plan=$costo_normal+$costo_extra+$costo_subc+$costo_stock+$costo_atraso+$suma_plan;
					
					echo "<tr><td>".$periodo."</td><td>".$demanda."</td><td>".$pro_normal."</td><td>".$pro_extra."</td><td>".$pro_subc."</td><td>".$pro_dem."</td><td>".$stock_inicial_actual."</td><td>".$stock_final_actual."</td><td>".$stock_medio_actual."</td><td>".$atraso_actual."</td>";
					echo '<td>'.$costo_normal.'</td><td>'.$costo_extra.'</td><td>'.$costo_subc.'</td><td>'.$costo_stock.'</td><td>'.$costo_atraso.'</td>';
					
					if(($pro_normal>=$min_normal) && ($pro_normal<=$max_normal)){
						if(($pro_extra>=$min_extra) && ($pro_extra<=$max_extra)){
							if(($pro_subc>=$min_subc)&&($pro_subc<=$max_subc)){
								if($stock_medio_variable!=0){ // es variable
									//echo "es variable el stock medio<br>";
									if($stock_medio_variable==$stock_medio_actual){ // compruebo que sea igual al que nos dio
										//echo "nos dio igual el stock medio<br>";
										if($stock_final_variable!=0){ // es variable
											//echo "stock final es variable<br>";
											if($stock_final_variable==$stock_final_actual){ // compruebo que sea igual al que nos dio
												//echo "nos dio bien el stock final<br>";
												if($atraso==0){ // no se permite postergar, es decir no puede haber retrasos
													//echo "no se permite postergar<br>";
													if($atraso==$atraso_actual){
														//echo "no se ha postergado nada<br>";
														if($normal_boolean==1){ // produccion normal es cte 
															if($pro_normal==$produccion_comparar){
																
															}else{
																echo "<td>La producción debe ser constante</td></tr>";
															}
														}
													}else{
														echo "<td>No se permiten atrasos</td></tr>";
													}
												}else{
													//echo "se puede postergar<br>";
													if($normal_boolean==1){ // produccion normal es cte 
													
														if($pro_normal==$produccion_comparar){
															
														}else{
															echo "<td>La producción debe ser constante </td></tr>";
														}
													}
												}
											}else{
												echo "<td>Debe mantener un stock final de ".$stock_final_variable."</td></tr>";
											}
										}else{
											//echo "no hay restricciones para stock final <br>";
											if($atraso_variable==0){ // no se permite postergar, es decir no puede haber retrasos
												//	echo "no se permite postergar<br>";
													if($atraso_variable==$atraso_actual){
														if($normal_boolean==1){ // produccion normal es cte 
															
															if($pro_normal==$produccion_comparar){
																
															}else{
																echo "<td>La producción debe ser constante </td></tr>";
															}
														}
													}else{
														echo "<td>No se permiten atraso1</td></tr>";
													}
											}else{
													if($normal_boolean==1){ // produccion normal es cte 
														if($pro_normal==$produccion_comparar){
															//echo "TODO OK<br>";
														}else{
															echo "<td>La producción debe ser constante </td></tr>";
														}
													}
												}
										}
									}else{
										echo "<td>Debe mantener un stock medio de ".$stock_medio_variable."</td></tr>";
										
									}
								}else{ 
										//echo " NO variable el stock medio<br>";
									if($stock_final_variable!=0){ // es variable
											//echo "es variable el stock final<br>";
										if($stock_final_variable==$stock_final_actual){ // compruebo que sea igual al que nos dio
											//echo "cumple stock final";
											if($atraso_variable==0){ // no se permite postergar, es decir no puede haber retrasos
												if($atraso_variable==$atraso_actual){
												//	echo "no se permiten atrasos y todo bien";
													if($normal_boolean==1){ // produccion normal es cte 

														if($pro_normal==$produccion_comparar){
															//echo "TODO OK<br>";
														}else{
															echo "<td>La producción debe ser constante </td></tr>";
														}
													}
												}else{
													echo "<tr><td>No se permiten atrasos2</td></tr>";
												}
											}else{
												if($normal_boolean==1){ // produccion normal es cte 
													//	echo "prod normal es cte<br>";
													if($pro_normal==$produccion_comparar){
														//echo "TODO OK<br>";
													}else{
														echo "<td>La producción debe ser constante </td></tr>";
													}
												}
											}
										}else{
											echo "<td>Debe mantener un stock final de ".$stock_final_variable."</td></tr>";
										}
									}else{
										//echo "no es variable el sotkc final <br>";
										if($atraso_variable==0){ // no se permite postergar, es decir no puede haber retrasos
										
											if($atraso_variable==$atraso_actual){
												//		echo "se permiten atrasos y todo bien<br>";
												if($normal_boolean==1){ // produccion normal es cte 
												
													if($pro_normal==$produccion_comparar){
														
													}else{
														echo "<td>La producción debe ser constante </td></tr>";
													}
												}
											}else{
												echo "<td>No se permiten atrasos3</td></tr>";
											}
										}else{
												//echo "no se permiten atrasos<br>";
											if($normal_boolean==1){ // produccion normal es cte 
												
												if($pro_normal==$produccion_comparar){
													
												}else{
													echo "<td>La producción debe ser constante </td></tr>";
												}
											}
										}
										
									}
								}
							}else{
								echo "<td>La producción subcontratada no se encuentra en el rango</td><tr> ";
							}
						}else{
							echo "<td>La producción con tiempo extra no se encuentra en el rango</td></tr> ";
						}	
					}else{
						echo "<td>La producción normal no se encuentra en el rango</td></tr> ";
					}
				}
				$valor=$valor+$uno;
			}
			$valor2=$valor2+1;
		}
		if($stock_medio_final!=0){
			$conexion = conectar();
			$sqlF = "call obtenerPlaneacionFinal('".$id."','".$cantidad."');";
			if($resultF = $conexion->query($sqlF)){
				if($resultF->num_rows >0){
					while($fila = mysqli_fetch_row($resultF)){
						$stock_medio_actual=$fila[8];
					}
					if($stock_medio_actual!=$stock_medio_final){
						echo "<td>Stock medio final debe ser igual a ".$stock_medio_final."</td><br>";
					}
				}
			}
		}
		echo '<tr class="odd"><td>TOTAL</td>:<td>'.$suma_plan.'</td></tr>';
	mysqli_close($conexion);	
?>