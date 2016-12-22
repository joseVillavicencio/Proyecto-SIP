function setProducto(value){
	localStorage.setItem('producto',value);
}
function getProducto(){
	return localStorage.getItem('producto');
}
function suave(div){
	var parametros = {
		'prod':getProducto(),
		'alpha1':document.getElementById('alpha1').value,
		'alpha2':document.getElementById('alpha2').value,
		'corte':document.getElementById('corte').value
	};
	$.ajax({
		data: parametros,
		url: "php/suave.php",
		type: "POST",
		
		success: function(response){			
			$(div).append(response);
			
		}
	});
}

function estacional(div){
	var parametros = {
		'prod':getProducto(),
		'ciclos':document.getElementById('ciclos').value
	};
	$.ajax({
		data:parametros,
		url:'php/calc_est.php',
		type:'POST',
		
		success: function(response){
			$(div).append(response)
			pro_indice(parametros);
		}
	});
}

function pro_indice(parametros){
	$.ajax({
		data:parametros,
		url:'php/pro_indi.php',
		type:'POST',
		
		success: function(response){
			$('#resultado').append(response)
		}
	});
}
