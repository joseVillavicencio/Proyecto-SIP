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
		
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarDatosMediaExponencial.php",
		type: "POST",
		
		success: function(response){			
			$(div).append(response);
		}
	});
}

function mostrarEcLineal(div){
	
	var parametros = {
		
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarDatosEcLineal.php",
		type: "POST",
		
		success: function(response){			
			
			$(div).append(response);
		}
	});
}
function mostrarDatosEcLineal(div){
	
	var parametros = {
		
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarParametrosEcLineal.php",
		type: "POST",
		
		success: function(response){			
			
			$(div).append(response);
		}
	});
}