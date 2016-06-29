<?php 
	// header('Content-Type: text/html; charset=utf-8');
	// //Se abre el archivo
	// $file = fopen("shop.xml", "r");
	// $xmlFile = "";
	// while(!feof($file)) {
	// 	$xmlFile .= fgets($file);
	// }
	// fclose($file);
	// //se pasa como servicio web
	// $items = new SimpleXMLElement($xmlFile);

	// foreach ($items as $item) {
	// 	if ($item->id == "1") {
	// 		echo $item->fichas;
	// 	}		
	// }
	

	function escapeChar($string)
	{	
		if (get_magic_quotes_gpc()!=1){
			$temp = stripslashes($string);
		}			
		$temp = htmlentities($string);
		$keys = array("!", "#", "$", "%", "&", "/", "(", ")", "'", "=", '"', "\\", "¡", "?", "¿", "*", "~", "[", "]", ".", "-", "¨", "<", ">", ",", ";");
		$temp = str_replace($keys, "", $string);
		return $temp;
	}

	echo "[[ ".escapeChar("!#$%&/()'=)(/&%¡?*¨[-.,<\"\\>")." ]]";
?>
