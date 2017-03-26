<?php
/*	
	$hoy = getdate();
	print_r($hoy);
	echo "\r\n";


	$dt = new DateTime('2015-07-31 12:11:10', new DateTimeZone('UTC'));
	print_r($dt);
	echo "\r\n";

	$dt->setTimezone(new DateTimeZone('America/Mexico_City'));
	print_r($dt);
*/

	date_default_timezone_set('America/Los_Angeles');

	//$datetime = new DateTime('2015-07-31 12:11:10');
	$datetime = getdate();
	echo $datetime->format('Y-m-d H:i:s') . "\n";
	$la_time = new DateTimeZone('America/Mexico_City');
	$datetime->setTimezone($la_time);
	echo $datetime->format('Y-m-d H:i:s');
?>