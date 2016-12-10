<?php 
	include('funcionesI.php');
	$conexion = conectar();
	$prod=$_POST['prod'];
	$ciclos=$_POST['ciclos'];
	
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
				//verificar si esta calculado
				$conexion=conectar();
				$sql1="SELECT id_est FROM pro_estacional WHERE ref_producto='".$id."'  AND ciclos='".$ciclos."';";
				if($sult=$conexion->query($sql1)){
					if($sult->num_rows>0){
						$refe;
						while($fila1=mysqli_fetch_row($sult)){
							$refe=$fila1[0];
						}
						//si lo esta: mostrar
						$conexion=conectar();
						$sql2="SELECT indice FROM pro_estacion WHERE ref_pro_estacional='".$refe."';";
						if($esu=$conexion->query($sql2)){
							if($esu->num_rows>0){
								$o=1;
								while($fila2=mysqli_fetch_row($esu)){
									echo '<tr><th>'.$o.'</th><th>'.$fila2[0].'</th></tr>';
									$o++;
								}
							}
						}
					}else{
						//sino: calcular la media movil centrada con el tamaño de ciclos
						$conexion=conectar();
						$largo=0;
						$datos=Array();
						$medias=Array();
						$indices=Array();
						$sql3="CALL obtenerDatosIniciales('".$id."');";
						if($rest=$conexion->query($sql3)){
							if($rest->num_rows>0){
								while($fila1= mysqli_fetch_row($rest)){
									$per=$fila1[0];
									$datos[$per]=$fila1[1];
									$largo++;
								}
							}
						}
						//el numero de ciclos es divisible por dos
						if($ciclos%2==0){
							echo "El ciclo ingresado es par";
						}else{
							$mediana=($ciclos+1)/2;
							$espacio=($ciclos-1)/2;
							for($i=1;$i<=$largo;$i++){
								if(($i<=$espacio)||($i>=($largo-$espacio))){
									$medias[$i]=0;
								}else{
									$answer=0;
									for($j=($i-$espacio);$j<=($i+$espacio);$j++){
										$answer=$answer+$datos[$j];
									}
									$medias[$i]=$answer/$ciclos;
									
								}
							}
							$veces=Array();
							for($n=1;$n<=$ciclos;$n++){
								$indices[$n]=0;
								$veces[$n]=0;
							}
							$l=1;
							for($k=1;$k<=$largo;$k++){
								if($l>$ciclos){
									$l=1;
								}
								if($medias[$k]==0){
									$l++;
								}else{
									$veces[$l]++;
									$indices[$l]=$indices[$l]+($datos[$k]/$medias[$k]);
									$l++;
								}
									//$indices[$k]=($datos[$k]/$medias[$k])
							}
							$conexion=conectar();
							$sql4="CALL insertarCiclo('".$id."','".$ciclos."');";
							if($rest1=$conexion->query($sql4)){
								if($rest1){
									$sql5="SELECT id_est FROM pro_estacional WHERE ref_producto='".$id."' AND ciclos='".$ciclos."';";
									$conexion=conectar();
									if($res=$conexion->query($sql5)){
										if($res->num_rows>0){
											while($fila=mysqli_fetch_row($res)){
												$refee=$fila[0];	
											}
											for($m=1;$m<=$ciclos;$m++){
												$r=$indices[$m]/$veces[$m];
												$conexion=conectar();
												$sql6="CALL insertarEstacion('".$refee."','".$r."','".$m."');";
												if($rets=$conexion->query($sql6)){
													if($rets){
														echo '<tr><th>'.$m.'</th><th>'.$r.'</th></tr>';
													}
												}
											}
										}
									}
								}
							}
						}//los datos entregados son divisibles por la cantidad de ciclos
					}
					//obtener los indices de los dividiendo la demanda obtenida por el valor de la media movil centrada
					//promediar los indices de los distintos ciclos obtenidos 
					//guardar los valores
				}
				
			}
		}
		mysqli_close($conexion);
	}
?>