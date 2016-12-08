<?php

	include('funcionesI.php');
	$conexion = conectar();
	$prod=$_POST['prod'];
	$corte=$_POST['corte'];
	$a1=$_POST['alpha1'];
	$a2=$_POST['alpha2'];
	$datos=Array();
	$largo=0;
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		//obtener producto
		$sql = "CALL buscarIdPro('".$prod."');";
		if($result = $conexion->query($sql)){
			if($result->num_rows >0){
				while($fila = mysqli_fetch_row($result)){
					$id=$fila[0];
				}
				//revisar si existe un pronostico del producto con los valores,  
				$conexion=conectar();
				$sql2="CALL revisarSuave('".$id."','".$corte."','".$a1."','".$a2."');";
				if($res=$conexion->query($sql2)){
					if($res->num_rows>0){
						//$sql3="CALL mostrarSuave('".$prod."','".$corte."','".$a1."','".$a2."');";
					}else{
						$conexion=conectar();
						$slq4="CALL obtenerDatosIniciales('".$id."');";
						if($rest=$conexion->query($slq4)){
							if($rest->num_rows>0){
								while($fila1= mysqli_fetch_row($rest)){
									$per=$fila1[0];
									$datos[$per]=$fila1[1];
									$largo++;
								}
							}
						}
						$largo=$largo-$corte;
						//obtener tt inicial con la pendiente del grafico demanda/periodo del primer y el periodo de corte((demanda_corte-demanda_inicial)/periodo_corte-periodo_inicial)		
						$ttinicial=(($datos[$corte]-$datos[1])/($corte-1));			
						//setear el valor de pronostico del periodo anterior al corte como la demanda de este mismo periodo
						$pt1_inicial=$datos[$corte]+$ttinicial;
						
						$conexion=conectar();
						$sql5="CALL insertarSuave('".$id."','".$datos[$corte]."','".$ttinicial."','".$pt1_inicial."','".$a1."','".$a2."','".$corte."');";
						echo $sql5;
						//echo $sql5;
						if($rest1=$conexion->query($sql5)){
							if($rest1){
								echo '<tr class="even"><th>'.$corte.'</th><th>'.$datos[$corte].'</th><th>'.$datos[$corte].'</th><th>'.$ttinicial.'</th><th>'.$pt1_inicial.'</th></tr>';
								//para cada periodo despues del de corte y el tambien 
								$pt_1=$datos[$corte];
								$pt1_ant=$pt1_inicial;
								$tt_1=$ttinicial;
								for($i=1;$i<=$largo;$i++){
									//calcular mt
									$error=($datos[$corte+$i]-$pt1_ant);
									$mt=$pt1_ant+($a1*$error);
									//calcular tt
									$errorTen=(($pt1_ant-$pt_1)-$tt_1);
									$tt=$tt_1+($a2*$errorTen);
									//calcular Pt+1
									$pt1=$mt+$tt;
									$conexion=conectar();
									$num=$corte+$i;
									$sql6="CALL insertarSuave('".$id."','".$datos[$num]."','".$tt."','".$pt1."','".$a1."','".$a2."','".$corte."');";
									if($rest3=$conexion->query($sql6)){
										if($rest3){
											echo '<tr class="even"><th>'.$num.'</th><th>'.$datos[$corte+$i].'</th><th>'.$mt.'</th><th>'.$tt.'</th><th>'.$pt1.'</th></tr>';
										}
									}
									$pt_1=$pt1_ant;
									$pt1_ant=$pt1;
									$tt_1=$tt;
								}
							}
						}
					}
				}
			}
		}
		mysqli_close($conexion);
	}
?>