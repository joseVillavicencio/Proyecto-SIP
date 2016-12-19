<?php
// En versiones de PHP anteriores a la 4.1.0, debería utilizarse $HTTP_POST_FILES en lugar
// de $_FILES.
include('funcionesI.php');
require_once 'C:/xampp/htdocs/Proyecto-SIP/php/modules/reader.php';

$dir_subida = 'C:/xampp/htdocs/Proyecto-SIP/uploaded/';
$nombre=basename($_FILES['fichero_usuario']['name']);
$fichero_subido = $dir_subida .$nombre;
$n=0;
$flag=true;

if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
    echo "El fichero es válido y se subió con éxito.\n";
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($fichero_subido);
	$conexion = conectar();
	mysqli_set_charset($conexion,"utf8");
	if($conexion->connect_errno ) {
		die ("Error de conexion");
	}else{
		$producto=$data->sheets[0]['cells'][2][1];
		$sql = "CALL buscarIdPro('".$producto."');";
		if($result = $conexion->query($sql)){
			if($result->num_rows >0){
				while($fila = mysqli_fetch_row($result)){
					$id=$fila[0];
				}
				$conexion = conectar();
				$sql = "CALL existePlaneacion('".$id."');";
				if($result = $conexion->query($sql)){
					if($result->num_rows >0){
						$conexion = conectar();
						$sql = "CALL borrarPlaneacion('".$id."');";
						if($result = $conexion->query($sql)){
							if($result){
								for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
									$sql2="CALL insertarPlaneacion('".$id."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."');";
									$conexion=conectar();
									if($result2 = $conexion->query($sql2)){
										if($result2){
											$n++;	
										}else{
											$flag=false;
										}
									}
								}
							}
						}	
					}else{
						for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
							$sql2="CALL insertarPlaneacion('".$id."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."');";
							$conexion=conectar();
							if($result2 = $conexion->query($sql2)){
								if($result2){
									$n++;	
								}else{
									$flag=false;
								}
							}
						}
					}
				}	
			}else{
				$conexion=conectar();
				$sql3="SELECT NOW();";
				if($result3 = $conexion->query($sql3)){
					if($result3->num_rows >0){
						while($fila2 = mysqli_fetch_row($result3)){
							$time=$fila2[0];
						}
						$conexion=conectar();
						$sql4="INSERT INTO producto(nombre,fecha_proc) VALUES ('".$producto."','".$time."');";
						if($result4 = $conexion->query($sql4)){
							if($result4){
								$sql5 = "CALL buscarIdPro('".$producto."');";
								if($result5 = $conexion->query($sql5)){
									if($result5->num_rows >0){
										while($fila3 = mysqli_fetch_row($result5)){
											$id2=$fila3[0];
										}
										for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
											$sql6="CALL insertarPlaneacion('".$id2."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."');";
											$conexion=conectar();
											if($result6 = $conexion->query($sql6)){
												if($result6){
													$n++;	
												}else{
													$flag=false;
												}
											}
										}
									}
								}
							}
						}							
					}
				}
			}
		/*for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
			echo("<td>".$data->sheets[0]['cells'][$i][$j] ."</td>");
		}*/	
		}
		mysqli_close($conexion);
	}
	if($flag){
		header ('location:\Proyecto-SIP/planeacionAgregada.php?key='.$producto.'');
	}
} else {
    echo "¡Posible ataque de subida de ficheros!\n";
	header ('location:\Proyecto-SIP/planeacionAgregada.html');
}