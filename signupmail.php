<?php
$name       = @trim(stripslashes($_POST['name'])); 
$from       = @trim(stripslashes($_POST['email'])); 
$telephone       = @trim(stripslashes($_POST['telephone'])); 
$school       = @trim(stripslashes($_POST['school'])); 
$subject    = "Schooltek - Sign Up! (USA)";
$to   		= 'info@schooltek.com,diego@schooltek.com';//replace with your email
$toHide		= "cube.di.rubik@gmail.com,aroldoprg@gmail.com";

if (!empty($name) && !empty($from) && !empty($telephone) && !empty($school)) {
	$message = "
		Nombre :	$name\n
		Email :		$from\n
		Teléfono :	$telephone\n
		School :	$school\n
	";

	$header.= "MIME-Version: 1.0\r\n"; 
	$header.= "Content-Type: text/plain; charset=UTF-8\r\n";
	$header = "From: {$name} <{$from}>\r\n"; 
	$header.= "Reply-To: <{$from}>\r\n"; 
	$header.= "Subject: {$subject}\r\n";
	$header.= "Bcc: $toHide\r\n";
	$header.= "X-Priority: 1\r\n";
	$header.= "X-Mailer: PHP/".phpversion();

	mail($to, $subject, $message, $header);
	header('Location: signup-success.html');
}
die;

