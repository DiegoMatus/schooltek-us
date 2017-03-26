<?php
$name       = @trim(stripslashes($_POST['name'])); 
$from       = @trim(stripslashes($_POST['email'])); 
$subject    = @trim(stripslashes($_POST['subject'])); 
$body   	= @trim(stripslashes($_POST['message'])); 
$to   		= 'info@schooltek.com,Lorenzo@schooltek.com,diego@schooltek.com';//replace with your email
$toHide		= "cube.di.rubik@gmail.com,aroldoprg@gmail.com";

if ( !empty($name) && !empty($from) && !empty($subject) && !empty($body) ) {
	$message = "
		Nombre :	$name\n
		Email :		$from\n
		Asunto :	$subject\n
		Mensaje :	$body\n
	";

	$header.= "MIME-Version: 1.0\r\n"; 
	$header.= "Content-Type: text/plain; charset=UTF-8\r\n";
	$header = "From: {$name} <{$from}>\r\n"; 
	$header.= "Reply-To: <{$from}>\r\n"; 
	$header.= "Subject: {$subject} (USA)\r\n"; 
	$header.= "Bcc: $toHide\r\n";
	$header.= "X-Priority: 1\r\n";
	$header.= "X-Mailer: PHP/".phpversion();

	mail($to, $subject, $message, $header);
}

die;

