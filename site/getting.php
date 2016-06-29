<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Iniciar sesión</title>
	<link rel="stylesheet" href="style/getting.css">
	<link rel="stylesheet" href="style/bootstrap.min.css">
	<link rel="shortcut icon" href="http://www.teofus.com/black-dofus-149440.png">
</head>
<body>
	<div class="row">
		<div class="col-md-10" id="logoTeofus">
			<img src="img/logoTeofus.png">
		</div>
	</div>
	<div id="main" class="row">
		<div class="row" id="panel">
			<div class="col-md-12" id="banner1">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-4"><span>Referidos Teofus</span></div>
				
			</div>
				
			</div>
			<div class="row" id="forms">
				<div class="col-md-6">
					<h1>Entrar a mi cuenta</h1>
					<br>
					<div class="form-group">
					    <label for="txt_cuenta">Nombre de cuenta</label><br>
					    <input type="text" class="txt" id="txt_cuenta" placeholder="" maxlength="30">
				  	</div>
				  	<div class="form-group">
					    <label for="txt_pass">Contraseña</label>
					    <input type="password" class="txt" id="txt_pass" placeholder="" maxlength="50">
				  	</div>

				  	<button type="button" class="bton" id="btn_entrar">ENTRAR</button><br/><br/>
				  	<button type="button" class="bton" title="Ir a crear una cuenta!" onclick="window.location.href = server + 'registro.php'">¿NO ESTÁS REGISTRADO?</button>
				</div>
				<div class="col-md-6" id="download">
					<div class="row">
						<div class="col-md-12" id="titleDown">							
							<h1>Descargar el juego</h1>
						</div>
						<div class="col-md-6 col-sm-6">
							<a href="http://teofus.com/TKes/windows">
								<img style="border-bottom: 1px solid black; padding: 10px; margin-left: 60px;" src="img/windows.jpg" title="Versión Windows" height="100">
							</a>							
						</div>
						<div class="col-md-6 col-sm-6">
							<a href="http://teofus.com/TKes/mac">
								<img style="border-bottom: 1px solid black; margin-bottom: 20px; margin-left: 20px; padding: 10px;" src="img/mac.png" title="Versión Mac" height="100">
							</a>							
						</div>
						<br/>
						<div class="col-md-12" id="google" title="Versión web sin descargas">
							<a href="http://teofus.com/teofusonline.php">
								<img src="img/google.png" height="100">
								<p style="margin-left: -10px; display: inline;">Juega desde el navegador Google Chrome.</p>	
							</a>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


		<!-- Mensaje de error -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_error">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Referidos Teofus.</h4>
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
	<script src="http://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="script/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="script/paises.js" type="text/javascript" charset="utf-8"></script>
	<script src="script/application.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>