<?php  
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	require "site/config.php";
	if(isset($_GET['by'])){
		$referidoPor=$_GET['by'];
		if(trim($referidoPor)!=""){
			$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
			$sql=$conn->prepare("SELECT id FROM cuentas WHERE id = ".$referidoPor);
			$sql->execute();
			$resultado=$sql->fetchAll();
			$id=0;
			foreach($resultado as $row){
				$id=$row['id'];
				}
			if($id!=0){
				echo "<script>var by = 'exists'</script>";
			}else{
				echo "<script>var by = 'unknow'</script>";
			}
		}
		else{
			echo "<script>var referidoPor = 0</script>";
		}
		echo "<script>var referidoPor = ".$referidoPor."</script>";
	}
	//Servicio
	if(isset($_POST["cmd"])){
		switch($_POST["cmd"]){
			case 'login':
				if(trim($_POST['cuenta'])==""||trim($_POST['contrasenia'])==""){
					echo "1";
					return;
				}
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				require "site/getIp.php";
				$_POST['cuenta'] = escapeChar($_POST['cuenta']);
				$_POST['contrasenia'] = escapeChar($_POST['contrasenia']);
				$sql=$conn->prepare("SELECT * FROM cuentas WHERE cuenta = '".$_POST['cuenta']."' AND contraseña = '".$_POST['contrasenia']."'");
				#echo "SELECT * FROM cuentas WHERE cuenta = '".$_POST['cuenta']."' AND contraseña = '".$_POST['contrasenia']."'";
				$sql->execute();
				$resultado=$sql->fetchAll();
				$cont=0;
				$id=0;
				$fichas=0;
				$ogrinas=0;
				$referidoPor=0;
				foreach($resultado as $row){
					$cont++;
					$id=$row['id'];
					$fichas=$row['fichas'];
					$ogrinas=$row['ogrinas'];
					$referidoPor=$row['referidoPor'];
				}
				if($cont==1){
					$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
					$sql=$conn->prepare('SELECT IF(c.logeado = 0,"Desconectado", "Conectado") AS "On/off", c.apodo AS "Apodo", c.cincoPorcDeOg AS "Cargas de OG", c.ogrinasReclamadas AS "Cargas reclamadas", (c.cincoPorcDeOg - c.ogrinasReclamadas) AS "Reclamar Og",	(SELECT COUNT(dynamic.personajes.cuenta) FROM dynamic.personajes WHERE dynamic.personajes.cuenta = c.id) AS "Fun",	(SELECT COUNT(ankalikedynamic.personajes.cuenta) FROM ankalikedynamic.personajes WHERE ankalikedynamic.personajes.cuenta = c.id) AS "Anka",	(SELECT COUNT(semilikedynamic.personajes.cuenta) FROM semilikedynamic.personajes WHERE semilikedynamic.personajes.cuenta = c.id) AS "Semi", c.id FROM cuentas c WHERE c.referidoPor ='.$id);
						$sql->execute();
						$resultado=$sql->fetchAll();
						$_SESSION['nombre']=$_POST['cuenta'];
						$_SESSION['password']=$_POST['contrasenia'];
						//// 23-02-2016
						/// Leer en el Json
						$_SESSION['baseRange'] = $id;
						$_SESSION['ogrinas']=$ogrinas;
						$_SESSION['referidoPor']=$referidoPor;
						//// End
						$_SESSION['fichas']=$fichas;
						$_SESSION['cuenta']=json_encode($resultado);
						echo "login";
				}else{
					echo "unknow";
				}
			break;
			case 'logout':
				session_destroy();
				echo "logout";
			break;
			case 'singin':
				require "site/getIp.php";
				$_POST['cuenta'] = escapeChar($_POST['cuenta']);
				$_POST['contrasenia'] = escapeChar($_POST['contrasenia']);
				$_POST['apodo'] = escapeChar($_POST['apodo']);
				$_POST['pais'] = escapeChar($_POST['pais']);
				$_POST['referidoPor'] = escapeChar($_POST['referidoPor']);

				if(trim($_POST['cuenta'])==""||trim($_POST['contrasenia'])==""||$_POST['apodo']==""){
					echo "1";
					return;
				}
				if($_POST['contrasenia']!=$_POST['rptPass']){
					echo "2";
					return;
				}
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare("SELECT id FROM cuentas WHERE cuenta = '".$_POST['cuenta']."'");
				$sql->execute();
				$resultado=$sql->fetchAll();
				$id=0;
				foreach($resultado as $row){
					$id=$row['id'];
				}
				if($id==0){
					$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
					$sql=$conn->prepare('INSERT INTO accounts.cuentas (cuenta, contraseña, apodo, pais, ipRegistro, idioma, referidoPor) VALUES ("'.$_POST['cuenta'].'","'.$_POST['contrasenia'].'","'.$_POST['apodo'].'","'.$_POST['pais'].'","'.get_real_ip().'","ES", '.$_POST['referidoPor'].')');
					$sql->execute();
					#echo 'INSERT INTO accounts.cuentas (cuenta, contraseña, apodo, pais, ipRegistro, idioma, referidoPor) VALUES ("'.$_POST['cuenta'].'","'.$_POST['contrasenia'].'","'.$_POST['apodo'].'","'.$_POST['pais'].'","'.get_real_ip().'","ES", '.$_POST['referidoPor'].')';
					echo "done";
				}else{
					echo "exists";
				}
			break;
			case 'view_fun':
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare('SELECT dynamic.personajes.id, (SELECT COUNT(idPj) FROM accounts.referidos_fun WHERE accounts.referidos_fun.idPj = dynamic.personajes.id) AS "exist" FROM dynamic.personajes WHERE dynamic.personajes.cuenta ='.$_POST['id']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$id=0;
				$retorno=array();
				foreach($resultado as $row){
					if($row['exist']==0){
						$sql=$conn->prepare('INSERT INTO referidos_fun (idcuenta, idPj) VALUES ("'.$_POST['id'].'", "'.$row['id'].'")');
						$sql->execute();
					}
					$sql=$conn->prepare('SELECT "'.$row['id'].'" AS "Id", p.nombre AS "Nombre", p.nivel AS "Nivel", p.resets AS "Resets", IF(r.r1Reclamado = 1, "Mano",IF(p.resets >= 1,"Chulo","Bloqueado")) AS "R1", IF(r.r2Reclamado = 1, "Mano",IF(p.resets >= 2,"Chulo","Bloqueado")) AS "R2", IF(r.r3Reclamado = 1, "Mano",IF(p.resets >= 3,"Chulo","Bloqueado")) AS "R3", IF(r.r4Reclamado = 1, "Mano",IF(p.resets >= 4,"Chulo","Bloqueado")) AS "R4", IF(r.r5Reclamado = 1, "Mano",IF(p.resets >= 5,"Chulo","Bloqueado")) AS "R5", IF(r.r6Reclamado = 1, "Mano",IF(p.resets >= 6,"Chulo","Bloqueado")) AS "R6", IF(r.r7Reclamado = 1, "Mano",IF(p.resets >= 7,"Chulo","Bloqueado")) AS "R7", IF(r.r8Reclamado = 1, "Mano",IF(p.resets >= 8,"Chulo","Bloqueado")) AS "R8" FROM dynamic.personajes p INNER JOIN accounts.referidos_fun r on p.id = r.idPj WHERE r.idPj = '.$row['id']);
					$sql->execute();
					$resultado=$sql->fetchAll();
					array_push($retorno,$resultado);
				}
				echo json_encode($retorno);
			break;
			case 'view_anka':
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare('SELECT ankalikedynamic.personajes.id, (SELECT COUNT(idPj) FROM accounts.referidos_ankalike WHERE accounts.referidos_ankalike.idPj = ankalikedynamic.personajes.id) AS "exist" FROM ankalikedynamic.personajes WHERE ankalikedynamic.personajes.cuenta = '.$_POST['id']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$id=0;
				$retorno=array();
				foreach($resultado as $row){
					if($row['exist']==0){
						$sql=$conn->prepare('INSERT INTO referidos_ankalike (idcuenta, idPj) VALUES ("'.$_POST['id'].'", "'.$row['id'].'")');
					$sql->execute();
					}
					$sql=$conn->prepare('SELECT "'.$row['id'].'" AS "Id", p.nombre AS "Nombre", p.nivel AS "Nivel", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 50,"Chulo","Bloqueado")) AS "Niv50", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 100,"Chulo","Bloqueado")) AS "Niv100", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 150,"Chulo","Bloqueado")) AS "Niv150", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 200,"Chulo","Bloqueado")) AS "Niv200" FROM ankalikedynamic.personajes p INNER JOIN accounts.referidos_ankalike r on p.id = r.idPj WHERE r.idPj = '.$row['id']);
					$sql->execute();
					$resultado=$sql->fetchAll();
					array_push($retorno,$resultado);
				}
				echo json_encode($retorno);
			break;
			case 'view_semi':
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare('SELECT semilikedynamic.personajes.id, (SELECT COUNT(idPj) FROM accounts.referidos_semilike WHERE accounts.referidos_semilike.idPj = semilikedynamic.personajes.id) AS "exist" FROM semilikedynamic.personajes WHERE semilikedynamic.personajes.cuenta = '.$_POST['id']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$id=0;
				$retorno=array();
				foreach($resultado as $row){
					if($row['exist']==0){
						$sql=$conn->prepare('INSERT INTO referidos_semilike (idcuenta, idPj) VALUES ("'.$_POST['id'].'", "'.$row['id'].'")');
						$sql->execute();
					}
					$sql=$conn->prepare('SELECT "'.$row['id'].'" AS "Id", p.nombre AS "Nombre", p.nivel AS "Nivel", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 50,"Chulo","Bloqueado")) AS "Niv50", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 100,"Chulo","Bloqueado")) AS "Niv100", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 150,"Chulo","Bloqueado")) AS "Niv150", IF(r.50Reclamado = 1, "Mano",IF(p.nivel >= 200,"Chulo","Bloqueado")) AS "Niv200" FROM semilikedynamic.personajes p INNER JOIN accounts.referidos_semilike r on p.id = r.idPj WHERE r.idPj = '.$row['id']);
					$sql->execute();
					$resultado=$sql->fetchAll();
					array_push($retorno,$resultado);
				}
				echo json_encode($retorno);
			break;
			case 'cobrarFichas':
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare('SELECT fichas FROM accounts.cuentas WHERE cuenta =  "'.$_POST['id'].'"');
				$sql->execute();
				$resultado=$sql->fetchAll();
				$fichasActual=0;
				foreach($resultado as $row){
					$fichasActual=$row['fichas'];
				}
				$fichasTotal=$fichasActual+$_POST['fichas'];
				$sql=$conn->prepare('UPDATE accounts.cuentas SET fichas = '.$fichasTotal.'  WHERE cuenta =  "'.$_POST['id'].'"');
				$sql->execute();
				$table=explode(",",$_POST['table']);
				$str="";
				if($_POST['server']=="1"){
					$str="UPDATE referidos_fun SET `r1Reclamado`=".$table[1].",`r2Reclamado`=".$table[2].",`r3Reclamado`=".$table[3].",`r4Reclamado`=".$table[4].",`r5Reclamado`=".$table[5].",`r6Reclamado`=".$table[6].",`r7Reclamado`=".$table[7].",`r8Reclamado`=".$table[8]." WHERE idCuenta = ".$_POST['idn']." AND idPj = ".$table[0];
				}else if($_POST['server']=="2"){
					$str="UPDATE referidos_ankalike SET `50Reclamado`=".$table[50].",`100Reclamado`=".$table[100].",`150Reclamado`=".$table[150].",`200Reclamado`=".$table[200]." WHERE idCuenta = ".$_POST['idn']." AND idPj = ".$table[0];
				}else if($_POST['server']=="3"){
					$str="UPDATE referidos_semilike SET `50Reclamado`=".$table[50].",`100Reclamado`=".$table[100].",`150Reclamado`=".$table[150].",`200Reclamado`=".$table[200]." WHERE idCuenta = ".$_POST['idn']." AND idPj = ".$table[0];
				}
				$sql=$conn->prepare($str);
				$sql->execute();
				echo $fichasTotal;
			break;
			case 'cobrarOgrinas':
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare('SELECT ogrinas FROM accounts.cuentas WHERE cuenta =  "'.$_POST['nombre'].'"');
				$sql->execute();
				$resultado=$sql->fetchAll();
				$ogrinasActual=0;
				foreach($resultado as $row){
					$ogrinasActual=$row['ogrinas'];
				}
				$ogrinasTotal=$ogrinasActual+$_POST['ogrinas'];
				$sql=$conn->prepare('UPDATE accounts.cuentas SET ogrinas = '.$ogrinasTotal.' WHERE cuenta = "'.$_POST['nombre'].'"');
				$sql->execute();
				$sql=$conn->prepare('UPDATE accounts.cuentas SET ogrinasReclamadas = '.$_POST['cinco'].' WHERE id = '.$_POST['alterid']);
				$sql->execute();
				echo $ogrinasTotal;
			break;
			case 'itemsShop':
				//Se abre el archivo
				$file = fopen("site/shop.xml", "r");
				$xmlFile = "";
				while(!feof($file)) {
					$xmlFile .= fgets($file);
				}
				fclose($file);
				//se pasa como servicio web
				$items = new SimpleXMLElement($xmlFile);
				echo json_encode($items);
			break;
			case 'buyitem':
				$server = $_POST['server'];
				$ObjectId = $_POST['object'];
				$valor = "";

				$file = fopen("site/shop.xml", "r");
				$xmlFile = "";
				while(!feof($file)) {
					$xmlFile .= fgets($file);
				}
				fclose($file);
				$items = new SimpleXMLElement($xmlFile);

				foreach ($items as $item) {
					if ($item->id == $ObjectId) {
						$valor = $item->fichas;
					}		
				}

				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				switch ($server) {
					case 'Fun':
						$server = "dynamic";
						break;
					case 'Semi':
						$server = "semilikedynamic";
						break;
					case 'Anka':
						$server = "ankalikedynamic";
						break;
					default:
					echo "No se reconoce el nombre del servidor";
						return;
				}
				//Validar que si se pueda comprar				
				$sql=$conn->prepare("SELECT cuenta FROM ".$server.".cuentas_servidor WHERE id = ".$_SESSION['baseRange']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$cont=0;
				foreach($resultado as $row){$cont++;}
				if ($cont == 0) {//si entra es por que no puede comprar
					echo json_encode(array("status"=>"error", "message"=>"No tienes personajes en el servidor ".$server.". Ve y crea un personaje para poder recibir regalos :)"));
					return;
				}
				//Primero quitar las fichas
				$sql=$conn->prepare('SELECT fichas FROM accounts.cuentas WHERE id =  '.$_SESSION['baseRange']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$fichasActual=0;
				$fichasTotal=0;
				foreach($resultado as $row){$fichasActual=$row['fichas'];}
				if ($fichasActual >= $valor) {//Si tiene fondos para comprar
					$fichasTotal = $fichasActual - $valor;
					$sql=$conn->prepare('UPDATE accounts.cuentas SET fichas = '.$fichasTotal.'  WHERE id =  '.$_SESSION['baseRange']);
					$sql->execute();
				}else{//No tiene fondos para comprar
					echo json_encode(array("status"=>"error", "message"=>"No tienes suficientes fondos para comprar este ítem :("));
					return;
				}				
				//Adquirir el objeto
				$sql=$conn->prepare('SELECT '.$server.'.cuentas_servidor.regalo FROM '.$server.'.cuentas_servidor where id ='.$_SESSION['baseRange']);
				$sql->execute();
				$resultado=$sql->fetchAll();
				$regaloActual="";
				foreach($resultado as $row){$regaloActual=$row['regalo'];}
				$regalototal = $regaloActual.$ObjectId.",";
				//Aqui falta el where
				$sql=$conn->prepare('UPDATE '.$server.'.cuentas_servidor SET '.$server.'.cuentas_servidor.regalo = "'.$regalototal.'" where id ='.$_SESSION['baseRange']);
				$sql->execute();

				echo json_encode(array("status"=>"done", "message"=>$fichasTotal));
			break;
			case "searh":
				//echo $_POST['txtsearch'];
				//echo $_POST['serverSearch'];
				$query = strtolower($_POST['txtsearch']); 
				$template = "";
				if ($_POST['serverSearch'] == "dynamic") {
					$template = "SELECT ac.logeado, ap.cuenta, ap.nombre, ap.nivel, ap.resets AS 'Rx' FROM ".$_POST['serverSearch'].".personajes ap INNER JOIN accounts.cuentas ac ON ac.id = ap.cuenta WHERE ap.nombre = '".$query."'";
				}else{
					$template = "SELECT ac.logeado, ap.cuenta, ap.nombre, ap.nivel, \"<span class='textInfo'>No aplica</span>\" AS 'Rx' FROM ".$_POST['serverSearch'].".personajes ap INNER JOIN accounts.cuentas ac ON ac.id = ap.cuenta WHERE ap.nombre = '".$query."'";
				}
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare($template);
				$sql->execute();
				$resultado=$sql->fetchAll();
				echo json_encode($resultado);
			break;
			case 'apadrinarme':
				$template = 'UPDATE cuentas SET referidoPor = '.$_POST['referido'].' WHERE id = '.$_SESSION['baseRange'];
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare($template);
				$sql->execute();
				#echo $template;
			break;
			default:
				echo json_encode(array("msg"=>"unknow"));
			break;
		}
	}
	//Home
	else if(isset($_SESSION['cuenta'])&&!isset($_GET['by'])&&!isset($_GET['cmd'])){


			if (isset($_SESSION['password'])) {//Esto para refrescar la sesión cuando se recarge la pagina :p
				$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
				$sql=$conn->prepare("SELECT * FROM cuentas WHERE cuenta = '".$_SESSION['nombre']."' AND contraseña = '".$_SESSION['password']."'");
				$sql->execute();
				$resultado=$sql->fetchAll();
				$cont=0;
				$id=0;
				$fichas=0;
				$ogrinas=0;
				$referidoPor=0;
				foreach($resultado as $row){
					$cont++;
					$id=$row['id'];
					$fichas=$row['fichas'];
					$ogrinas=$row['ogrinas'];
					$referidoPor=$row['referidoPor'];
				}
				if($cont==1){
					$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
					$sql=$conn->prepare('SELECT IF(c.logeado = 0,"Desconectado", "Conectado") AS "On/off", c.apodo AS "Apodo", c.cincoPorcDeOg AS "Cargas de OG", c.ogrinasReclamadas AS "Cargas reclamadas", (c.cincoPorcDeOg - c.ogrinasReclamadas) AS "Reclamar Og",	(SELECT COUNT(dynamic.personajes.cuenta) FROM dynamic.personajes WHERE dynamic.personajes.cuenta = c.id) AS "Fun",	(SELECT COUNT(ankalikedynamic.personajes.cuenta) FROM ankalikedynamic.personajes WHERE ankalikedynamic.personajes.cuenta = c.id) AS "Anka",	(SELECT COUNT(semilikedynamic.personajes.cuenta) FROM semilikedynamic.personajes WHERE semilikedynamic.personajes.cuenta = c.id) AS "Semi", c.id FROM cuentas c WHERE c.referidoPor ='.$id);
						$sql->execute();
						$resultado=$sql->fetchAll();
						// $_SESSION['nombre']=$_POST['cuenta'];
						// $_SESSION['password']=$_POST['contrasenia'];
						//// 23-02-2016
						/// Leer en el Json
						$_SESSION['baseRange'] = $id;
						$_SESSION['ogrinas']=$ogrinas;
						$_SESSION['referidoPor']=$referidoPor;
						//// End
						$_SESSION['fichas']=$fichas;
						$_SESSION['cuenta']=json_encode($resultado);
					}		
			}


			echo "<script>var cuenta = '".$_SESSION['cuenta']."'</script>";
			echo "<script>var nombre = '".$_SESSION['nombre']."'</script>";
			echo "<script>var fichasServer = '".$_SESSION['fichas']."'</script>";
			echo "<script>var ogrinasServer = '".$_SESSION['ogrinas']."'</script>";
			echo "<script>var baseRange = '".$_SESSION['baseRange']."'</script>";
			include ("site/index.php");
	}
	//Login
	else
	{
		include ("site/getting.php");
	}
?>