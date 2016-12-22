function getProducto(){
	return localStorage.getItem('producto');
}
function setProducto(value){
	localStorage.setItem('producto',value);
}


function mostrarEcLineal(div){
	
	var parametros = {

		'p':getProducto(),
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
		'p':getProducto(),
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
function enviarParametro(div){

	var c=document.getElementById("c").value; //SETEAR VARIABLE LOCAL DEL PRODUCTO
	var parametros = {
		"c" : c,
		'p':getProducto(),
	}
	$.ajax({
		data: parametros,
		url: "php/calcularMExponencial.php",
		type: "POST",
		
		success: function(response){			
			
			if(response==1){
				var parametros = {
					"c" : c,
					'p':getProducto()
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
		}
	});
}
function mostrarC(div){
	
	var parametros = {
		'p':getProducto(),
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarCorrelacion.php",
		type: "POST",
		
		success: function(response){			
			
			$(div).append(response);
		}
	});
}
function mostrarDatosC(div){
	
	var parametros = {
		'p':getProducto(),
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarParametrosCorrelacion.php",
		type: "POST",
		
		success: function(response){			
			
			$(div).append(response);
		}
	});
}
function obtenerOpcionLugar(name){
	var elementos = document.getElementsByName(name);
	for(var i=0; i< elementos.length; i++){
		if(elementos[i].checked){
			return elementos[i].value;
		}
	}
	
}
function obtenerPlaneacion(div){
	var stock_medio=0;
	var stock_inicial=document.getElementById("stock_inicial").value;
	var stock_final=0;
	var stock_medio_final=0;
	var normal_boolean=0;
	var atraso=1;
	
	if($("#atraso").is(':checked')){
		atraso=document.getElementById("atraso").value;
	}
	var normal_boolean=0;
	var extra_boolean=0;
	var subc_boolean=0;
	
	if($("#stock_medio").is(':checked')){
		stock_medio=document.getElementById("c1").value;
		
	}
	
	if($("#stock_final").is(':checked')){
		stock_final=document.getElementById("c2").value;
		
	}
	
	if($("#stock_medio_final").is(':checked')){
		stock_medio_final=document.getElementById("c3").value;
		
	}
	var min_normal=document.getElementById("min_normal").value;
	var max_normal=document.getElementById("max_normal").value;
	
	
	if($("#normal_boolean").is(':checked')){
		var normal_boolean=document.getElementById("normal_boolean").value;
	}
	
	var min_extra=document.getElementById("min_extra").value;
	var max_extra=document.getElementById("max_extra").value;
	
	
	var min_subc=document.getElementById("min_subc").value;
	var max_subc=document.getElementById("max_subc").value;
	//var sub_boolean=document.getElementById("subc_boolean").value;
	if($("#subc_boolean").checked){
		var subc_boolean=document.getElementById("subc_boolean").value;
	}
	var parametros = {
		'producto':getProducto(),
		'stock_inicial' : stock_inicial,
		'stock_medio': stock_medio,
		'stock_final': stock_final,
		'atraso' : atraso,
		'min_normal' : min_normal,
		'max_normal' : max_normal,
		'normal_boolean': normal_boolean,
		'min_extra' : min_extra,
		'max_extra': max_extra,
		'min_subc' : min_subc,
		'max_subc': max_subc,
		'stock_medio_final' : stock_medio_final
	}
	$.ajax({
		data: parametros,
		url: "php/calcularPlaneacion.php",
		type: "POST",
		
		success: function(response){			
			
		
			if(response==1){
				var parametros = {
					'producto':getProducto(),
					'stock_inicial' : stock_inicial,
					'stock_medio': stock_medio,
					'stock_final': stock_final,
					'atraso' : atraso,
					'min_normal' : min_normal,
					'max_normal' : max_normal,
					'normal_boolean': normal_boolean,
					'min_extra' : min_extra,
					'max_extra': max_extra,
					'min_subc' : min_subc,
					'max_subc': max_subc,
					'stock_medio_final' : stock_medio_final
				}
				$.ajax({
					data: parametros,
					url: "php/mostrarPlaneacion.php",
					type: "POST",
					
					success: function(response){			
						$(div).append(response);
					}
				});
			}else{
				alert("Ha ocurrid un problema");
			}
		}
	});
}
function mostrarC(div){
	
	var parametros = {
		'p':getProducto(),
	}
	$.ajax({
		data: parametros,
		url: "php/mostrarCorrelacion.php",
		type: "POST",
		
		success: function(response){			
			
			$(div).append(response);
		}
	});
}

function graficar(div){
	var parametros={
		'prod':getProducto();
	};
	$.ajax({
		data: parametros,
		url: "php/datos_grafico.php",
		type: "POST",
		dataType: "JSON",
		cache:	false,
		
		success: function(response){			
			Highcharts.chart(div, {
				chart: {type: 'spline'}, 
				title: {text: 'Gráfico de Demanda historico'},
				xAxis: {title: { text: 'Periodo'}},
				yAxis: { title: { text: 'Demanda'},labels: {formatter: function () { return this.value + '°';}}},
				tooltip: {crosshairs: true,shared: true},
				plotOptions: {spline: {marker: {radius: 4,lineColor: '#666666',lineWidth: 1}}},
				series: [{name: 'Female',color: 'rgba(223, 83, 83, .5)',data:response}]
			});
		}
	});
}
