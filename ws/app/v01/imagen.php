<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		//$id = $_GET['id'];
		$logueado = login($usr,$pwd,$ce);
		if ($logueado) {
			include('connectdbcustom.php');

			$query = "SELECT bLogo, sNomLogo, sMimeTypeLogo
						FROM PCBCENTROEDUC 
						WHERE idCentroEduc=1";
			$sqlcode = mysql_query($query,$cnnDBCUSTOM);
			$row = mysql_fetch_array($sqlcode);
			$contenido = $row['bLogo'];
			$tipo = $row['sMimeTypeLogo'];
			header("Content-type: ".$tipo."");
			echo $contenido;
			mysql_close($cnnDBCUSTOM);
		}else{	
			echo '{"login":"N"}';
		}
	}else{
		echo '{"login":"N"}';
	}

?>