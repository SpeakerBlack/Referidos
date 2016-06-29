<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registrate</title>
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
					<h1>Crear una cuenta</h1>
					<br>
					<div class="form-group">
					    <label for="txt_cuentaR">Nombre de cuenta</label><br>
					    <input type="text" class="txt" id="txt_cuentaR" placeholder="" maxlength="30">
				  	</div>
				  	<div class="form-group">
					    <label for="txt_passR">Contraseña</label>
					    <input type="password" class="txt" id="txt_passR" placeholder="" maxlength="50">
				  	</div>
				  	<div class="form-group">
					    <label for="txt_rptPass">Repetir contraseña</label>
					    <input type="password" class="txt" id="txt_rptPass" placeholder="" maxlength="50">
				  	</div>
				  	<div class="form-group">
					    <label for="txt_apodo">Apodo</label><br>
					    <input type="text" class="txt" id="txt_apodo" placeholder="" maxlength="30">
				  	</div>
				  	<div class="form-group">
					    <label for="slect_pais">Pais</label><br>
					    	<select id="slect_pais" class="txt">
					    </select><br><br>
					    <span id="lbl_byUnknow">
					    	La cuenta a la que te refieres no existe!<br>
					    	Sin embargo puedes continuar con el registro.
				    	</span>
				  	</div>
				  	<?php
					      //muestra el recaptcha en el formulario
					      require('recaptchalib.php');
					      $publickey = "6Lff5voSAAAAAFPhxJZJMqFY9QcVykf-pSR0CdpE";
					      echo recaptcha_get_html($publickey);
					?>
				  	<!-- <div class="g-recaptcha" data-theme="dark" data-sitekey="6Lff5voSAAAAAFPhxJZJMqFY9QcVykf-pSR0CdpE"></div> -->
					<br>
				  	<button type="button" id="btn_registro" class="bton">CREAR CUENTA</button><br/><br/>
				  	<button type="button" class="bton" title="Ir al inicio de sesión" onclick="window.location.href = './'">¿YA ESTÁS REGISTRADO?</button>
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