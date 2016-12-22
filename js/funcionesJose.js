function setProducto(value){
	localStorage.setItem('producto',value);
}
function getProducto(){
	return localStorage.getItem('producto');
}
function suave(div){
	alert("entra");
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
			alert(response);
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
function graficare(){
	var parametros={
		'prod':getProducto()
	};
	$.ajax({
		data: parametros,
		url: "php/datos_grafico.php",
		type: "POST",
		dataType: "JSON",
		cache:	false,
		
		success: function(response){	
			graph(response);
		}
	});
}
function graph(datos){
	Highcharts.chart('graphic', {
		chart: {type: 'spline'}, 
		title: {text: 'Gráfico de Demanda historico'},
		xAxis: {title: { text: 'Periodo'}},
		yAxis: { title: { text: 'Demanda'},labels: {formatter: function () { return this.value;}}},
		tooltip: {crosshairs: true,shared: true},
		plotOptions: {spline: {marker: {radius: 4,lineColor: '#666666',lineWidth: 1}}},
		series: [{name: 'Productos',color: 'rgba(223, 83, 83, .5)',data:datos}]
	});
}


