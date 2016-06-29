+function (w, d, undefined) {
	var id = new Date().getTime().toString();
	
	if (w.localStorage.appID === undefined) {
		w.localStorage.appID = id;
		
		w.onbeforeunload = function () {
			w.localStorage.removeItem('appID'); // Removemos la variable en localStorage
		};
	} else if (w.localStorage.appID !== id) {
		d.body.style.display = "none"
		alert('Ya tienes una sesión abierta, vuelve atras.');
	}			
} (window, document);


var server = window.location.origin + window.location.pathname;
$(document).ready(function(){
	//iniciar sesion
	$( "#btn_entrar" ).click(function() {
		// document.getElementById('main').style.cursor = 'wait';
		document.getElementById("lbl_error").innerHTML = "Iniciando sesión...";
				$('#modal_error').modal();
	  $.ajax({
	    // En data puedes utilizar un objeto JSON, un array o un query string
	    data: {"cmd":"login","cuenta" : $("#txt_cuenta").val(), "contrasenia" : $("#txt_pass").val()},
	    //Cambiar a type: POST si necesario
	    type: "POST",
	    // URL a la que se enviará la solicitud Ajax
	    url: server,
		})
		 .done(function( data, textStatus, jqXHR ) {
		 	console.log(data);
			if (data == "login") {
				window.location = server;
			}else if(data == "1"){
				document.getElementById("lbl_error").innerHTML = "Complete los campos requeridos para inicar sesión";
				$('#modal_error').modal();
			}else{
				document.getElementById("lbl_error").innerHTML = "Usuario o contraseña incorrectos.";
				$('#modal_error').modal();
			};
		     
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
		});
	});

	//Cerrar sesión
	$( "#btn_logout" ).click(function() {
		$.ajax({
	    // En data puedes utilizar un objeto JSON, un array o un query string
	    data: {"cmd":"logout"},
	    //Cambiar a type: POST si necesario
	    type: "POST",
	    // URL a la que se enviará la solicitud Ajax
	    url: server,
		})
		 .done(function( data, textStatus, jqXHR ) {
			if (data == "logout") {
				window.location = server;
			}else{
				document.getElementById("lbl_error").innerHTML = "Oops! Algo salio mal al intentar cerrar sesión.";
			$('#modal_error').modal();
			};
		     
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
		});
	});

	//Registro
	$( "#btn_registro" ).click(function() {
		var v1 = $("input#recaptcha_challenge_field").val();
            var v2 = $("input#recaptcha_response_field").val();
                   
            $.ajax({
                  type: "POST",
                  url: server.substring(0, server.lastIndexOf("/")+1)+"recaptcha.php",
                  data: {
                            "recaptcha_challenge_field" : v1, 
                            "recaptcha_response_field" : v2
                  },
                  dataType: "text",
                  error: function(data){
                        alert("Error al enviar la capcha");
                  },
                  success: function(data){ 
                  		//referidoPor = referidoPor;
                        if (data != 0) {//Entra si la captcha es correcta
                        	if (typeof(by) == "undefined") {
                        		referidoPor = 0;
                        	}
						  $.ajax({
						    // En data puedes utilizar un objeto JSON, un array o un query string

						    data: {"cmd":"singin","cuenta" : $("#txt_cuentaR").val(), "contrasenia" : $("#txt_passR").val(), "apodo" : $("#txt_apodo").val(), "pais" : document.getElementById("slect_pais").value, "referidoPor":referidoPor, "rptPass":$("#txt_rptPass").val()},
						    //Cambiar a type: POST si necesario
						    type: "POST",
						    // URL a la que se enviará la solicitud Ajax
						    url: server.substring(0, server.lastIndexOf("/")+1),
							})
							 .done(function( data, textStatus, jqXHR ) {
								if (data == "done") {
									$("#txt_cuentaR").val("");
									$("#txt_passR").val("");
									$("#txt_rptPass").val("");
									$("#txt_apodo").val("");
									document.getElementById("lbl_error").innerHTML = "Registro exitoso!<br>Ahora puedes iniciar sesión.";
									$('#modal_error').modal();
								}else if (data == "1"){
									document.getElementById("lbl_error").innerHTML = "Complete los campos requeridos para el registro";
									$('#modal_error').modal();
								}else if(data == "2"){
									document.getElementById("lbl_error").innerHTML = "Las contraseñas no coinciden.";
									$('#modal_error').modal();
								}
								else{
									document.getElementById("lbl_error").innerHTML = "Ya existe una cuenta registrada con este nombre, intenta con otro.";
									$('#modal_error').modal();
								};
							     
							 })
							 .fail(function( jqXHR, textStatus, errorThrown ) {
							     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
								$('#modal_error').modal();
							});
                        }else{//Si la captcha es incorecta
                        	Recaptcha.reload();
                        	document.getElementById("lbl_error").innerHTML = "Error en reCAPTCHA, Intentelo de nuevo...";
								$('#modal_error').modal();
                        }
                  }
            });
	});

	//Obtener datos de la cuenta cuando se inicia sesion
	if(typeof(cuenta) != "undefined"){
	 	cuenta = jQuery.parseJSON(cuenta);
	 	var template = "";
	 	var cont = 0;
	 	var lon = cuenta.length;
	 	for (var i = 0; i < lon; i++) {
	 		template += "<tr>";
	 		for (var j = 0; j < 8; j++) {	 			
	 			if (j == 4) {
	 				if (cuenta[i][j] < 0) {
	 					template += "<td class='textInfo'>Sin ogrinas</td>";
 						continue;
	 				}
	 				if (cuenta[i][j] == 0) {
	 					template += "<td class='textInfo'>Sin ogrinas</td>";
	 				}else{
	 					template += "<td><span class='btn_cobrar' id='"+cuenta[i][j]+"_"+cont+"' onclick='cobrarOg(this.id)'>Reclamar</span> "+cuenta[i][j]+" Og.</td>";
	 				}
				}else if (j > 4){
					if(cuenta[i][j] >= 1){			
						switch(j) {
						    case 5:
						        template += "<td><span class='lbl_ver' onclick='viewFun(this.id)' title='Ver información detallada sobre el personaje (FUN)' id='"+cont+"' >Ver</span></td>";
						        break;
						    case 6:
						        template += "<td><span class='lbl_ver' onclick='viewAnka(this.id)' title='Ver información detallada sobre el personaje (ANKA)' id='"+cont+"' >Ver</span></td>";
						        break;
						    case 7:
						    	template += "<td><span class='lbl_ver' onclick='viewSemi(this.id)' title='Ver información detallada sobre el personaje (SEMI)' id='"+cont+"' >Ver</span></td>";
						        break;
						} 
						
					} else {
						template += "<td class='textInfo'>Sin personaje</td>";
					}			
	 			} else {
	 				if (cuenta[i][j] === "Conectado") {
						template += "<td><img src='img/online.png' class='img_estado' title='Conectado'/></td>";
	 				} else if (cuenta[i][j] === "Desconectado") {
	 					template += "<td><img src='img/offline.png' class='img_estado' title='Desconectado'/></td>";
	 					
	 				} else {
						template += "<td>"+cuenta[i][j]+"</td>";
	 				}	 				
	 			}
		 	}
		 	template += "</tr>";
		 	cont++;
	 	} 
	 	document.getElementById('bodytable').innerHTML = template;
	 	document.getElementById('lbl_cuenta').innerHTML = nombre;
	 	document.getElementById('lbl_fichas').innerHTML = fichasServer + " Fichas.";
	 	document.getElementById('lbl_ogrinas').innerHTML = ogrinasServer + " Ogrinas.";
	 	document.getElementById('lbl_link').innerHTML = "Link de registro para referidos:<br/>"+server+"registro.php?by="+baseRange;
	}
	else{ 
		//No existe
	}

	//Avisa si el referido existe
	if (typeof(by) != "undefined") {
		if (by != "unknow" ) {
			document.getElementById("lbl_byUnknow").style.display = "none";
		}
	}else{
		if(document.getElementById("lbl_byUnknow") != null){
			document.getElementById("lbl_byUnknow").style.display = "none";
		}
	}
	

	//cargar paises

	if (document.getElementById("slect_pais") != null) {
		var lon = paises.length;
		var template = "";
		for (var i = 0; i < lon; i++) {
			template += "<option value='"+paises[i].sigla+"'>"+paises[i].nome_pais_int+"</option>";
		}
		document.getElementById("slect_pais").innerHTML = template;
	}

	
	//$('.lbl_ver_fun').click(function(){console.log("Por aqui pase");viewFun(this.id);});
		//Ver personaje FUN
});
function viewFun(id){
		$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"view_fun","id" : cuenta[id].id},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
		 .done(function( data, textStatus, jqXHR ) {
			//Ya sabemos, mostrar el modal

			data = jQuery.parseJSON(data);
			var template = "";
			var fichas = [];
			var ficha = 0;
			var table = [-1,1,2,3,4,5,6,7,8];

			for (var i = 0; i < data.length; i++) {
				template += "<tr>";
				template += "<td>"+data[i][0].Nombre+"</td>";
				template += "<td>"+data[i][0].Nivel+" [R"+data[i][0].Resets+"]</td>";

				for (var j = 1; j <= 8; j++) {
					var img = data[i][0]['R'+j] == "Mano"?"img/up.png":
						  data[i][0]['R'+j] == "Chulo"?"img/ok.png":
						  "img/no.png";
				    R = {"R1":10, "R2":20, "R3":30,"R4":40, "R5":50, "R6":60,"R7":70, "R8":80};
					if (data[i][0]['R'+j] == "Chulo") {
						ficha += R['R'+j];
					}
					template += "<td><img class='img_info' src='"+img+"'></td>";
					if (data[i][0]['R'+j] == "Chulo" || data[i][0]['R'+j] == "Mano") {
						table[j] = 1;
					}else if(data[i][0]['R'+j] == "Bloqueado"){
						table[j] = 0;
					}

				}
				table[0] = data[i][0].Id;
				if (ficha != 0) {
					template += "<td><span class='btn_cobrar' id='"+id+"' data-dismiss='modal' onclick='cobrarFichas(this.id, this.children[0].innerHTML, this.children[0].id, 1)'>Cobrar <b id='"+table+"'>"+ficha+"</b> fichas</span></td>";
				}else{
					template += "<td><span class='textInfo'><b>0</b> fichas</span></td>";
				}		
				fichas.push(ficha);
				ficha = 0;
				template += "</tr>";
			}

			document.getElementById("bodytableFun").innerHTML = template;
			
			$('#modal_view_fun').modal();		     
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
		});
	} 
function viewAnka(id){
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"view_anka","id" : cuenta[id].id},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
		 .done(function( data, textStatus, jqXHR ) {
			//Ya sabemos, mostrar el modal
			// console.log(data);
			data = jQuery.parseJSON(data);
			//console.log(data);
			//console.log(data);
			var template = "";
			var fichas = []
			var ficha = 0;
			var table = [-1,1,2,3,4,5,6,7,8];

			for (var i = 0; i < data.length; i++) {
				template += "<tr>";
				template += "<td>"+data[i][0].Nombre+"</td>";
				template += "<td>"+data[i][0].Nivel+"</td>";

				for (var j = 50; j <= 200; j+=50) {
					//console.log(data[i][0]['Niv'+j]);
					var img = data[i][0]['Niv'+j] == "Mano"?"img/up.png":
						  data[i][0]['Niv'+j] == "Chulo"?"img/ok.png":
						  "img/no.png";
				    N = {"Niv50":5,"Niv100":15,"Niv150":20,"Niv200":35};
				    if (data[i][0]['Niv'+j] == "Chulo") {
						ficha += N['Niv'+j];
					}
					template += "<td><img class='img_info' src='"+img+"'></td>";
					if (data[i][0]['Niv'+j] == "Chulo" || data[i][0]['Niv'+j] == "Mano") {
						table[j] = 1;
					}else if(data[i][0]['Niv'+j] == "Bloqueado"){
						table[j] = 0;
					}
				}
				// switch(ficha) {
				//     case 1:
				//         ficha = 5;
				//         break;
				//     case 2:
				//         ficha = 15;
				//         break;
				//     case 3:
				//         ficha = 20;
				//         break;
				//     case 4:
				//         ficha = 35;
				//         break;
				// } 
				table[0] = data[i][0].Id;
				if (ficha != 0) {
					template += "<td><span class='btn_cobrar' id='"+id+"' data-dismiss='modal' onclick='cobrarFichas(this.id, this.children[0].innerHTML, this.children[0].id, 2)'>Cobrar <b id='"+table+"'>"+ficha+"</b> fichas</span></td>";
				}else{
					template += "<td><span class='textInfo'><b>0</b> fichas</span></td>";
				}
						
				fichas.push(ficha);
				ficha = 0;

				template += "</tr>";
			}
			document.getElementById("lbl_title").innerHTML = "Ankalike";
			document.getElementById("bodytableAnka").innerHTML = template;
			

			$('#modal_view_anka').modal();		     
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
		});
}
function viewSemi(id){
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"view_semi","id" : cuenta[id].id},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
		 .done(function( data, textStatus, jqXHR ) {
			//Ya sabemos, mostrar el modal
			// console.log(data);

			data = jQuery.parseJSON(data);
			//console.log(data);
			var template = "";
			var fichas = []
			var ficha = 0;
			var table = [-1,1,2,3,4,5,6,7,8];
			var N;
			for (var i = 0; i < data.length; i++) {
				template += "<tr>";
				template += "<td>"+data[i][0].Nombre+"</td>";
				template += "<td>"+data[i][0].Nivel+"</td>";

				for (var j = 50; j <= 200; j+=50) {
					//console.log(data[i][0]['Niv'+j]);
					var img = data[i][0]['Niv'+j] == "Mano"?"img/up.png":
						  data[i][0]['Niv'+j] == "Chulo"?"img/ok.png":
						  "img/no.png";
					N = {"Niv50":3,"Niv100":10,"Niv150":15,"Niv200":25};
					if (data[i][0]['Niv'+j] == "Chulo") {
						ficha += N['Niv'+j];
					}
					template += "<td><img class='img_info' src='"+img+"'></td>";
					if (data[i][0]['Niv'+j] == "Chulo" || data[i][0]['Niv'+j] == "Mano") {
						table[j] = 1;
					}else if(data[i][0]['Niv'+j] == "Bloqueado"){
						table[j] = 0;
					}
				}
				// switch(ficha) {
				//     case 1:
				//         ficha = 3;
				//         break;
				//     case 2:
				//         ficha = 10;
				//         break;
				//     case 3:
				//         ficha = 15;
				//         break;
				//     case 4:
				//         ficha = 25;
				//         break;
				// } 
				table[0] = data[i][0].Id;
				if (ficha != 0) {
					template += "<td><span class='btn_cobrar' id='"+id+"' data-dismiss='modal' onclick='cobrarFichas(this.id, this.children[0].innerHTML, this.children[0].id, 3)'>Cobrar <b id='"+table+"'>"+ficha+"</b> fichas</span></td>";
				}else{
					template += "<td><span class='textInfo'><b>0</b> fichas</span></td>";
				}
						
				fichas.push(ficha);
				ficha = 0;

				template += "</tr>";
			}
			document.getElementById("lbl_title").innerHTML = "Semilike";

			document.getElementById("bodytableAnka").innerHTML = template;

			$('#modal_view_anka').modal();		     
		 })
		 .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
		});
}

function cobrarFichas(id, fichas, table, serverGame){
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"cobrarFichas","id" : nombre, "fichas":fichas, "table":table, "idn":cuenta[id].id, "server":serverGame},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 		document.getElementById('lbl_fichas').innerHTML = data + " Fichas.";
	 });
}

//Captcha
function captcha(){
            var v1 = $("input#recaptcha_challenge_field").val();
            var v2 = $("input#recaptcha_response_field").val();
                   
            $.ajax({
                  type: "POST",
                  url: server+"recaptcha.php",
                  data: {
                            "recaptcha_challenge_field" : v1, 
                            "recaptcha_response_field" : v2
                  },
                  dataType: "text",
                  error: function(){
                        alert("Error en la captcha");
                  },
                  success: function(data){ 
                        //alert(data);
                  }
            });
             
      }
function cobrarOg(id){
	var ogrinas = parseInt(id.split("_")[0]);
	var id = parseInt(id.split("_")[1]);
	var cinco = document.getElementById('table_main').childNodes[1].rows[id+1].cells[2].innerHTML;
	document.getElementById('table_main').childNodes[1].rows[id+1].cells[3].innerHTML = cinco;
	document.getElementById('table_main').childNodes[1].rows[id+1].cells[4].innerHTML = "Sin ogrinas"
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"cobrarOgrinas","nombre" : nombre, "ogrinas":ogrinas, "cinco":cinco, "alterid":cuenta[id].id},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 		document.getElementById('lbl_ogrinas').innerHTML = data + " Ogrinas.";
	 		//console.log(data);
	 });
}
function itemsShop(){
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string
			data: {"cmd":"itemsShop"},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 		data = jQuery.parseJSON(data);
 			var template = "";
	 		data = data.item;
 			for (var i = 0; i < data.length; i++) {
 				template += "<tr>";
 				template += "<td>" + data[i].nombre + "</td>";
 				template += "<td>" + data[i].fichas + "</td>";

 				var Nserver = data[i].disponible;
 				template += "<td><form>";
				if (Nserver.fun == "true") {
					template += '<input type="radio" name="server" value="Fun"> Fun<br/>';
				}

				if (Nserver.anka == "true") {
					template += '<input type="radio" name="server" value="Anka"> Ankalike<br/> ';
				}

				if (Nserver.semi == "true") {
					template += '<input type="radio" name="server" value="Semi"> Semilike<br/> ';
				}

 				template += "</form></td>";
 				template += "<td><span class='btn_cobrar' id='shop_"+data[i].id+"' onclick='buyItem(this.id);'>Comprar</span></td>";
 				template += "</tr>";
 			}

 			document.getElementById("bodytableShop").innerHTML = template;
 			
	 		$('#modal_shop').modal();
	 });
}
canExit = false;
function buyItem(_id){
	//console.log("Llego");
	var temp = -1;
	var Mserver = document.getElementById(_id).parentNode.previousSibling.childNodes[0].getElementsByTagName('input');
	for (var i = 0; i < Mserver.length; i++) {
		if (Mserver[i].checked === true) {
			temp = Mserver[i].value;
			break;
		}
	}
	if (temp === -1) {
		document.getElementById('lbl_errorShop').innerHTML = "Debe seleccionar un servidor.";
		return;
	}else{
		Mserver = temp;
	}
	_id = _id.replace("shop_","");
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"buyitem","object" : _id, "server":Mserver},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 		//document.getElementById('lbl_fichas').innerHTML = data + " Fichas.";
	 		data = jQuery.parseJSON(data);
	 		if (data.status == "done") {
	 			 window.onbeforeunload = confirmExit;
	 			 canExit = false;
	 			document.getElementById('lbl_fichas').innerHTML = data.message + " Fichas.";
	 			document.getElementById('lbl_errorShop').innerHTML = "Ítem comprado! " + data.message + " fichas total.";
	 			canExit = true;
	 		}else if (data.status == "error") {
 				document.getElementById('lbl_errorShop').innerHTML = data.message;
	 		}
	 		
	 })
	  .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
	});
}
function confirmExit()
{
	if (!canExit) {
		return "AÚN NO SE CARGA EL OBJETO A TUS REGALOS, ESPERA UNOS SEGUNDOSS!";
	}					
}

function search() {
	var serverSearch = "";
	if ($("#rnd_fun")[0].checked === true) {
		serverSearch = "dynamic";
	}
	if ($("#rnd_anka")[0].checked === true) {
		serverSearch = "ankalikedynamic";
	}
	if ($("#rnd_semi")[0].checked === true) {
		serverSearch = "semilikedynamic";
	}

	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"searh", "txtsearch":$("#txt_search").val(), "serverSearch": serverSearch},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 		//document.getElementById('lbl_fichas').innerHTML = data + " Fichas.";
	 		var template = "";
	 		data = jQuery.parseJSON(data);

	 		if (data.length === 0) {
		 		template += "<tr class='textInfo'>\
							<td>Sin resultado</td>\
							<td>Sin resultado</td>\
							<td>Sin resultado</td>\
							<td>Sin resultado</td>\
							<td>Sin resultado</td>\
						</tr>"
				document.getElementById('bodytablePadrino').innerHTML = template;
	 		}else{
		 		template += "<tr>";
		 		template += "<td>"+ (data[0].logeado == "0" ? "<img src='img/offline.png' class='img_estado' title='Desconectado'/>" : "<img src='img/online.png' class='img_estado' title='Conectado'/>") +"</td>";
		 		template += "<td>"+data[0].nombre+"</td>";
		 		template += "<td>"+data[0].nivel+"</td>";
		 		template += "<td>"+data[0].Rx+"</td>";
		 		template += "<td><span class='btn_cobrar' onclick='apadrinarme(this.id)' data-dismiss='modal' id='"+data[0].cuenta+"'>Apadrinarme</span></td>";
		 		template += "</tr>";

		 		document.getElementById('bodytablePadrino').innerHTML = template;	
	 		}	
	 })
	  .fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
	});

}

function apadrinarme(id) {
	$.ajax({
			// En data puedes utilizar un objeto JSON, un array o un query string

			data: {"cmd":"apadrinarme", "referido":id},
			//Cambiar a type: POST si necesario
			type: "POST",
			// URL a la que se enviará la solicitud Ajax
			url: server,
		})
	 .done(function( data, textStatus, jqXHR ) {
	 	//console.log(data);
	 	location.reload(true);
	 }).fail(function( jqXHR, textStatus, errorThrown ) {
		     document.getElementById("lbl_error").innerHTML = "No se puede conectar con el servidor...<br>Intentelo mas tarde.";
			$('#modal_error').modal();
	});
}