<?php 
	require_once('site/recaptchalib.php');
	$privatekey = "6Lff5voSAAAAAEdcAq0jrRMaqeLU8JJv3PspZOZT";
	$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	  //ERROR EN EL CAPTCHA
	  echo 0;
	}else{
	  //CAPTCHA CORRECTO
	  echo 1;
	}
 ?>