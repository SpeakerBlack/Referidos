<?php 
    function get_real_ip()
    { 
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR']; 
    }
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
 ?>