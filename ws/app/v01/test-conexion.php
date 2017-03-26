<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$logueado = login($usr,$pwd,$ce);
		if ($logueado) {
			echo '{"login":"S", "mensaje:":"Si entrooooo"}';
		}else{
			echo '{"login":"N"}';
			
		}
	}else{
		echo '{"login":"N"}';
	}

?>