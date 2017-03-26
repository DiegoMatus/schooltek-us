<?php
	include('general.php');
	//include('user.php');
	
	$s = file_get_contents('calificacion.txt');
	$a = unserialize($s);
	$a->obtUsr();
	//session_start();
	//echo $_SESSION['foo']->obtUsr();
?>