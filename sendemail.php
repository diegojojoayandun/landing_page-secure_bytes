<?php

if ($_POST['g-recaptcha-response'] == '') {
	echo "Captcha invalido";
	print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
	} else {
	$obj = new stdClass();
	$obj->secret = "6LeEREEcAAAAAHhDHL_hKff_iByWpd6VbjHVfA1W";
	$obj->response = $_POST['g-recaptcha-response'];
	$obj->remoteip = $_SERVER['REMOTE_ADDR'];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	
	$options = array(
	'http' => array(
	'header' => "Content-type: application/x-www-form-urlencoded\r\n",
	'method' => 'POST',
	'content' => http_build_query($obj)
	)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	
	$validar = json_decode($result);
	
	/* FIN DE CAPTCHA */

	if ($validar->success) {

		$EmailFrom="noreply@securebytes.co";
		$EmailTo="comercial@securebytes.co";
		//$Subject="Email from the Contact Form";
		$Name=Trim(stripslashes($_POST['name']));
		$Email=Trim(stripslashes($_POST['email']));
		$Subject=Trim(stripslashes($_POST['subject']));
		$Message=Trim(stripslashes($_POST['message']));

		// simple way to validate the form
		$ValidationOk=true;
		if ($Name == "") $ValidationOk=false;
			if (!$ValidationOk) {
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
				exit;
			}
				
			// preparing the body of the email 
			$Body="";
			$Body.="Name: ";
			$Body.=$Name;
			$Body.="\n";

			$Body.="Email: ";
			$Body.=$Email;
			$Body.="\n";

			$Body.="Message: ";
			$Body.=$Message;
			$Body.="\n";

			//sending the email now
			$success=mail($EmailTo, $Subject, $Body,"From: <$EmailFrom>");

			//redirect after mail send 
			if ($success) {
		
			print "<meta http-equiv=\"refresh\" content=\"0;URL=send.html\">";

			}
			else {

				print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";

			}
		} else {
			print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
			}
			}
?>