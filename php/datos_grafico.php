<?php
	include('funcionesI.php');
	$conexion = conectar();
	$prod=$_POST['prod'];
	$jotason= array();
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
				$conexion=conectar();
				$slq2="CALL obtenerDatosIniciales('".$id."');";
						if($rest=$conexion->query($slq2)){
							if($rest->num_rows>0){
								while($fila1= mysqli_fetch_row($rest)){
									$arreglo= array($fila1[0],$fila[1]);
									array_push($jotason,$arreglo);
								}
								echo json_encode($jotason);
							}
						}
					}
				}
			}
		}
		mysqli_close($conexion);
	}
?>