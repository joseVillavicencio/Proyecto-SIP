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
				$id;
				while($fila = mysqli_fetch_row($result)){
					$id=$fila[0];
				}
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
					$sql2="CALL actualizarExcelPlaneacion('".$id."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."');";
					$conexion=conectar();
					if($result2 = $conexion->query($sql2)){
						if($result2){
							$n++;	
						}else{
							$flag=false;
						}
					}
				}
			}else{
				echo "Ocurrió un problema";
			}
		
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