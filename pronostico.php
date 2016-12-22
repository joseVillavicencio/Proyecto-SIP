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
	<script src="js/funcionesJose.js" type="text/javascript"></script>

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

    
  </head>
  <body>
  
  	<!-- NAVIGATION MENU -->

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
             
              <li class="active"><a href="pronostico.php"><i class="icon-th icon-white"></i>Previsión</a></li>
			  <li><a href="planeacionAgregada.php"><i class="icon-th icon-white"></i>Planificación</a></li>
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
      	    <h2><center><strong>Seleccione la técnica de previsión </strong></center></h2>
			<br>
      		<div class="row">
      			<div class="col-sm-offset-1 col-sm-2 col-lg-offset-1 col-lg-2">
      				<div id="hosting-table">
						<div class="table_style4"> 
							<div class="column">
								<ul>
				                  	<li><strong>Media  Móvil Exponencial</strong></li>
									<li class="header_row">
										<h4 style="color:white">Promedio</h4>
									</li>
									
									<li class="footer_row"><a href="mediaExponencialMovil.html" class="hosting-button">Seleccionar</a></li>
								</ul>
							</div><!--/ column-->
						</div><!--/ Table Style-->
					</div><!--/ Hosting Table-->	
      			</div><!-- /span3 -->	
      			<div class="col-sm-2 col-lg-2">
      				<div id="hosting-table">
						<div class="table_style4"> 
							<div class="column">
								<ul>
				                  	<li><strong>Ecuación Lineal</strong></li>
									<li class="header_row">
										<h4 style="color:white">Tendencia</h4>
									</li>
									
									<li class="footer_row"><a href="ecuacionLineal.html" class="hosting-button">Seleccionar</a></li>
								</ul>
							</div><!--/ column-->
						</div><!--/ Table Style-->
					</div><!--/ Hosting Table-->	
      			</div><!-- /span3 -->	
      			<div class="col-sm-2 col-lg-2">
      				<div id="hosting-table">
						<div class="table_style4"> 
							<div class="column">
								<ul>
				                  	<li><strong>Suavizado Exponencial</strong></li>
									<li class="header_row">
										<h4 style="color:white">Tendencia</h4>
									</li>
									<li class="footer_row"><a href="suavizadoExponencial.html" class="hosting-button">Seleccionar</a></li>
								</ul>
							</div><!--/ column-->
						</div><!--/ Table Style-->
					</div><!--/ Hosting Table-->	
      			</div><!-- /span3 -->	
      			<div class="col-sm-2 col-lg-2">
      				<div id="hosting-table">
						<div class="table_style4"> 
							<div class="column">
								<ul>
				                  	<li><strong>Estacionalidad</strong></li>
									<li class="header_row">
										<h4 style="color:white">Estacionalidad</h4>
									</li>
									<li class="footer_row"><a href="seriesTemporales.html" class="hosting-button">Seleccionar</a></li>
								</ul>
							</div><!--/ column-->
						</div><!--/ Table Style-->
					</div><!--/ Hosting Table-->	
					
      			</div><!-- /span3 -->	
				<div class="col-sm-2 col-lg-2">
      				<div id="hosting-table">
						<div class="table_style4"> 
							<div class="column">
								<ul>
				                  	<li><strong>Correlaciones</strong></li>
									<li class="header_row">
										<h4 style="color:white">Correlación</h4>
									</li>
									<li class="footer_row"><a href="correlaciones.html" class="hosting-button">Seleccionar</a></li>
								</ul>
							</div><!--/ column-->
						</div><!--/ Table Style-->
					</div><!--/ Hosting Table-->	
				</div>
      		</div><!-- /row -->
      	</div><!-- /container -->
      	<br><br><br><br>
	<!-- FOOTER -->	
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


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    

  
</body></html>