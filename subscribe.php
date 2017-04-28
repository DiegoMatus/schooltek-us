<?php
$email       = @trim(stripslashes($_POST['email'])); 
$subject    = "Schooltek - Newsletter! (USA)";
$to   		= 'info@schooltek.com,diego@schooltek.com';//replace with your email
$toHide		= "";

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if (!empty($email)) {
	$ip = get_client_ip();
	$message = "
		Email :		$email\n
		IP:			$ip
	";

	$header.= "MIME-Version: 1.0\r\n"; 
	$header.= "Content-Type: text/plain; charset=UTF-8\r\n";
	$header = "From: {$email} <{$email}>\r\n"; 
	$header.= "Reply-To: <{$email}>\r\n"; 
	$header.= "Subject: {$subject}\r\n"; 
	$header.= "Bcc: $toHide\r\n";
	$header.= "X-Priority: 1\r\n";
	$header.= "X-Mailer: PHP/".phpversion();

	mail($to, $subject, $message, $header);
	//header('Location: index.html');

	if($_POST){
        $subjectRep =   "Thank you for subscribing!";
        $messageRep =   "You will receive our notifications in your email.";

		$headerRep.= "MIME-Version: 1.0\r\n"; 
		$headerRep.= "Content-Type: text/plain; charset=UTF-8\r\n";
		$headerRep = "From: schooltek.com <info@schooltek.com>\r\n"; 
		$headerRep.= "Reply-To: <info@schooltek>\r\n"; 
		$headerRep.= "Subject: {$subjectRep}\r\n"; 
		$headerRep.= "X-Priority: 1\r\n";
		$headerRep.= "X-Mailer: PHP/".phpversion();

        if(mail($email, $subjectRep, $messageRep, $headerRep)){
			echo json_encode("Respuesta enviada");
        }
	}
}
die;

