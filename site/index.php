<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Mi Cuenta</title>
	<link rel="stylesheet" href="style/getting.css">
	<link rel="stylesheet" href="style/bootstrap.min.css">
	<link rel="shortcut icon" href="http://www.teofus.com/black-dofus-149440.png">
</head>
<body id="index">	
	<?php 
		//20500
		if ($_SESSION['baseRange'] >= 20500 AND $_SESSION['referidoPor'] == 0) {
			echo '<a id="lbl_padrino" onclick="$(\'#modal_padrino\').modal();"><span>!Aún no tiene un padrino¡<br/>!Busca un padrino para ti y dile que ayude en el juego¡</span></a>';
		}
	?>
	<div id="table_main">
		<table class="table" >
	  		<caption>
				<div class="row">
					<div class="col-md-3">
						<span id="lbl_cuenta"></span>
						<div id="lbl_panel">
							<span id="lbl_fichas">Fichas</span><br/>
							<span id="lbl_ogrinas">Ogrinas</span>
						</div>						
					</div>
					<div class="col-md-2">
						<div id="panel_shop" title="Clic para abrir la tienda" onclick="itemsShop();">
							<img src="img/shop.png">
						</div>						
					</div>
					<div class="col-md-5">
						<span id="lbl_link"></span>
					</div>
					<div class="col-md-2">
						<button type="button" id="btn_logout" class="bton">Cerrar sesión</button>
					</div>
				</div>
	  		</caption>
	  		 <thead> 
	  		 	<tr> 
	  		 		<th>Estado</th> 
	  		 		<th>Apodo</th>
	  		 		<th>Cargas de OG</th>
  		 		 	<th>Cargas reclamadas</th> 
  		 		  	<th>Reclamar OG</th>
  		 		  	<th>Fun</th>
  		 		  	<th>Ankalike</th>
  		 		  	<th>Semilike</th>
	  		 	</tr>
	  		 </thead>
	  		 <tbody id="bodytable">

	  		 </tbody>
		</table>
	</div>

	<!-- Mensaje de error -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_error">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Oops! Tenemos un problema.</h4>
	      </div>
	      <div class="modal-body">
	        <p id="lbl_error"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal de personaje fun -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_fun">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Fun</h4>
	      </div>
	      <div class="modal-body">
	        <!-- Cuerpo o tabla -->
	        <table class="table">
				<thead> 
		  		 	<tr> 
		  		 		<th>Personaje</th> 
		  		 		<th>Nivel[Rx]</th>
		  		 		<th>R1</th>
		  		 		<th>R2</th>
		  		 		<th>R3</th>
		  		 		<th>R4</th>
		  		 		<th>R5</th>
		  		 		<th>R6</th>
		  		 		<th>R7</th>
		  		 		<th>R8</th>
		  		 		<th>Cobrar</th>
		  		 	</tr>
		  		 </thead>
		  		 <tbody id="bodytableFun">

		  		 </tbody>
			</table>
			<img src="img/tablaFun.png" alt="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal de personaje anka -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_view_anka">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="lbl_title"></h4>
	      </div>
	      <div class="modal-body">
	        <!-- Cuerpo o tabla -->
	        <table class="table">
				<thead> 
		  		 	<tr> 
		  		 		<th>Personaje</th> 
		  		 		<th>Nivel</th>
		  		 		<th>Nivel 50</th>
		  		 		<th>Nivel 100</th>
		  		 		<th>Nivel 150</th>
		  		 		<th>Nivel 200</th>
		  		 		<th>Cobrar</th>
		  		 	</tr>
		  		 </thead>
		  		 <tbody id="bodytableAnka">

		  		 </tbody>
			</table>
	      </div>
	      <img src="img/tablaAnkaSemi.png" alt="">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Modal de tienda -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_shop">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <span id="lbl_errorShop"></span>
	        <h4 class="modal-title">Tienda por fichas</h4>

	      </div>
	      <div class="modal-body">	        
			<table class="table">
				<thead> 
		  		 	<tr> 
		  		 		<th>Item</th> 
		  		 		<th>Precio en fichas</th>
		  		 		<th>Enviar al servidor...</th>
		  		 		<th>Comprar</th>
		  		 	</tr>
		  		 </thead>
		  		 <tbody id="bodytableShop">

		  		 </tbody>
			</table>
	      </div>
	      <img src="img/infoShop.png" alt="">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal de padrino -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_padrino">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <span id="lbl_errorPadrino"></span>
	        <h4 class="modal-title">Búsqueda de padrino</h4>

	      </div>
	      <div class="modal-body">
	      	
	      	<div class="row">
	      		<div class="col-md-3" style="margin-right: -60px; padding-top:5px;">
	      			<div class="form-group">
		      			<label for="txt_search">Nombre del personaje:</label>
	      			</div>
	      		</div>
	      		<div class="col-md-4">
	      			<div class="form-group">
	      				<input type="text" class="form-control" placeholder="Futuro padrino" id="txt_search">
      				</div>
	      		</div>
	      		<div class="col-md-3">
	      			<div class="form-group">
	      				<input type="button" class="btn btn-primary" value="Buscar" onclick="search();">
      				</div>
	      		</div>
	      	</div>
	      	<div class="row">
	      		<div class="col-md-3" style="margin-right: -60px; padding-top:5px;">
	      			<div class="form-group">
		      			<label for="txt_search">Buscar en:</label>
	      			</div>
	      		</div>
	      		<div class="form-group">
		      		<div class="col-md-2"><input type="radio" name="serverSearch" value="rnd_fun"  id="rnd_fun" placeholder="Fun" checked="true"> <label for="rnd_fun">Fun</label></div>
		      		<div class="col-md-2"><input type="radio" name="serverSearch" value="rnd_anka" id="rnd_anka" placeholder="Ankalike"> <label for="rnd_anka">Ankalike</label></div>
		      		<div class="col-md-2"><input type="radio" name="serverSearch" value="rnd_semi" id="rnd_semi" placeholder="Semilike"> <label for="rnd_semi">Semilike</label></div>
	      		</div>
	      	</div>	    
			<table class="table">
				<thead> 
		  		 	<tr> 
		  		 		<th>Estado</th> 
		  		 		<th>Personaje</th>
		  		 		<th>Nivel</th>
		  		 		<th>Rx</th>
		  		 		<th>Hacerme padrino</th>
		  		 	</tr>
		  		 </thead>
		  		 <tbody id="bodytablePadrino">
						<tr class="textInfo">
							<td>Esperando...</td>
							<td>Esperando...</td>
							<td>Esperando...</td>
							<td>Esperando...</td>
							<td>Esperando...</td>
						</tr>
		  		 </tbody>
			</table>
	      </div>
	      <img src="img/infoPadrino.png" alt="">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script src="http://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="script/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="script/application.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>