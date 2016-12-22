<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>SIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <!-- DATA TABLE CSS -->
    <link href="assets/css/table.css" rel="stylesheet">
	<script src="js/funcionesPrevision.js" type="text/javascript"></script>


    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  	<!-- Google Fonts call. Font Used Open Sans -->
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="assets/js/datatables/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#dt1').dataTable();
			} );
	</script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
    
  </head>
  <body>
	<div class="navbar-nav navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.html"><img src="assets/img/logo30.png" alt=""> SIP</a>
			</div> 
			  <div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="#"><i class="icon-th icon-white"></i>Previsión</a></li>
					<li class="active"><a href="planeacionAgregada.php"><i class="icon-th icon-white"></i>Planificación</a></li>
					<li><a href="gestion_stock.html"><i class="icon-th icon-white"></i>Gestión de Stock</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
		</div>
	</div>
		<?php
		$producto=$_GET['key'];
		echo "<input type='hidden' id='nProd' value=".$producto.">";
		?>
		<script type="text/javascript">
			setProducto($("#nProd").val());
		</script>
		<div class="container">
			
			<h3 style="color:black;text-align:center;">Planeación Agregada</h3><br>
			<div class="row" >
				<div class="col-lg-6 col-sm-6 col-md-6">
					<h4><strong>Restricciones Stock Inicial</strong></h4><br>
					<label>Ingrese Stock Inicial:</label><input value="50" name="stock" id="stock_inicial" class="input-huge" type="text"><br>
					
					<h4><strong>Restricciones Stock Medio</strong></h4><br>
					<label><input type="checkbox" id="stock_medio" onclick="$('#c1').prop('disabled',false);"> Tiene que mantener un stock medio de </label>
					<label><input type="text"  id="c1" disabled></label><br><br>
					<label><input type="checkbox" id="stock_medio_final"  onclick="$('#c3').prop('disabled',false);"> Tiene un valor en el último período de</label>
					<label><input type="text" id="c3" disabled></label><br><br>
					
					<h4><strong>Restricciones Stock Final</strong></h4><br>
					<label><input type="checkbox" id="stock_final" value="cte" onclick="$('#c2').prop('disabled',false);"> Tiene un valor en el último período de</label>
					<label><input type="text" id="c2" disabled></label><br><br>
					<h4><strong>Atraso</strong></h4>	
					<label><input type="checkbox" id="atraso" value="0"> No se permite postergar atrasos</label><br><br>
					
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6">	 
					<h4><strong>Restricciones Turno Normal</strong></h4><br>
					<label>Mínimo Valor Permitido:<input value="1" name="stock" id="min_normal" class="input-huge" type="text"></label><br><br>
					<label>Max Valor Permitido:<input name="stock" value="251" id="max_normal" class="input-huge" type="text"></label><br>
					<label><input type="checkbox" id="normal_boolean" value="1" checked> Es constante</label><br><br>
					
					<h4><strong>Restricciones Producción Turno Extra<strong></h4><br>
					<label>Mínimo Valor Permitido:<input name="stock" value="0" id="min_extra" class="input-huge" type="text"></label><br><br>
					<label>Max Valor Permitido:<input name="stock" value="0" id="max_extra" class="input-huge" type="text"></label><br>
					
				
					<h4><strong>Restricciones Producción Subcontratada</strong></h4><br>
					<label>Mínimo Valor Permitido:<input name="stock" id="min_subc" value="0" class="input-huge" type="text"></label><br><br>
					<label>Max Valor Permitido:<input name="stock" value="0" id="max_subc" class="input-huge" type="text"></label><br>
				</div>
			</div>
			<div class="row" style="text-align:center;">
				<button class="btn btn-success" onclick="obtenerPlaneacion('#planeacion');" >Calcular</button>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Cambiar Datos</button>
			</div>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content" align="center">
							  <div class="modal-header"  style="color:black;">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Actualizar Excel</h4>
							  </div>
						<div class="modal-body">
							<form enctype="multipart/form-data" action="php/actualizar_excel.php" method="POST">
								<!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
								<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
								<!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
								Enviar este fichero: <input name="fichero_usuario" type="file" /><br>
								<input type="submit" value="Enviar fichero" /><br>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<h4><strong>Resultado</strong></h4>
					<table class="display">
						  <thead>
							<tr>
							  <th>Periodo</th>
							  <th>Demanda</th>
							  <th>Producción Normal</th>
							  <th>Producción Tiempo Extra</th>
							  <th>Producción Subcontratada</th>
							  <th>Producción - Demanda</th>
							  <th>Stock Inicial</th>
							  <th>Stock Final</th>
							  <th>Stock Medio</th>
							  <th>Atraso</th>
							  <th>Comentario</th>
							</tr>
						  </thead>
						<tbody id="planeacion">
							
						</tbody>
					</table><!--/END First Table -->
					 <br>
				</div><!--/span12 -->
			</div><!-- /row -->
		</div> <!-- /container -->
			<br>   	
			<br>
			
		<div id="footerwrap">
			<footer class="clearfix"></footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-12">
					<p><img src="assets/img/logo.png" alt=""></p>
					<p>Sitio Desarrollado por Dania Delgado- José Villavicencio- Copyright 2016</p>
					</div>

				</div><!-- /row -->
			</div><!-- /container -->		
		</div><!-- /footerwrap -->
  
   
  

  
</body></html>