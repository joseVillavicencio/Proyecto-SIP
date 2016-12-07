function mandarDatos(div){
	
	var parametros = {
		"periodo": localStorage.getItem("periodo"),
		"demanda": localStorage.getItem("demanda")
	}
	$.ajax({
		data: parametros,
		url: "procesar.php",
		type: "POST",
		
		success: function(response){			
			$(div).append(response);
			
		}
	});
}
function mostrarMediaExponencial(div){
	
	var parametros = {
		"periodo": localStorage.getItem("periodo"),
		"demanda": localStorage.getItem("demanda")
	}
	$.ajax({
		data: parametros,
		url: "procesar.php",
		type: "POST",
		
		success: function(response){			
			$(div).append(response);
			
		}
	});
}

