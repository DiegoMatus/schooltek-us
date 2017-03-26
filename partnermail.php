<?php
$name       = @trim(stripslashes($_POST['name'])); 
$from       = @trim(stripslashes($_POST['email'])); 
$phone		= @trim(stripslashes($_POST['phone'])); 
$id 		= @trim(stripslashes($_POST['id']));
$city 		= @trim(stripslashes($_POST['city']));
$state		= @trim(stripslashes($_POST['state']));
$zip 		= @trim(stripslashes($_POST['zip']));
$company 	= @trim(stripslashes($_POST['company']));
$which 		= @trim(stripslashes($_POST['which']));
$description = @trim(stripslashes($_POST['description']));
$giro		=@trim(stripslashes($_POST['giro']));
$comments	= @trim(stripslashes($_POST['comments']));
$subject 	= 'Be a partner (USA)';
$to   		= 'info@schooltek.com,Lorenzo@schooltek.com,diego@schooltek.com';

if (!empty($name) && !empty($from) && !empty($phone) && !empty($id) && !empty($city) && !empty($state)  
	&& !empty($zip) && !empty($company) && !empty($giro) ) {
	$message = "
		Nombre :\t\t$name\n
		Email :\t\t$from\n
		Teléfono :\t\t$phone\n
		id :\t\t$id\n
		city :\t\t$city\n
		state :\t\t$state\n
		zip :\t\t$zip\n
		company :\t\t$company\n
		which :\t\t$which\n
		description :\t\t$description\n
		giro :\t\t$giro\n
		comments :\t\t$comments\n
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
}

die;

