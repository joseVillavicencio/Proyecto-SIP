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
				$conexion=conectar();
				$largo=0;
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
				$prono;
				$prom=0;
				$nume=($largo+1)%$ciclos;
				for($i=($largo-$ciclos+1);$i<=$largo;$i++){
					$prom=$prom+$datos[$i];
				}
				$prom=$prom/$ciclos;
				$sql2="SELECT indice FROM pro_estacion AS P INNER JOIN pro_estacional AS E ON P.ref_pro_estacional=E.id_est WHERE E.ref_producto='".$id."' AND P.nume='".$nume."';";
				//echo $sql2;
				$conexion=conectar();
				if($res=$conexion->query($sql2)){
					if($res->num_rows>0){
						while($fila2=mysqli_fetch_row($res)){
							$prono=$prom*$fila2[0];
						}
						echo '<label> El pronostico para el periodo siguiente es: '.$prono.' '.$prod.'s.</label>';
					}
				}
				//$prom=$prom*$indice;
				//echo '<label> El pronostico para el periodo siguiente es: '.$prom.' '.$prod.'s.</label>';
			}
		}
		mysqli_close($conexion);
	}
?>