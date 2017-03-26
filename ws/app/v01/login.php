<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];

		$logueado = login($usr,$pwd,$ce);
		if ($logueado) {
			$close_cnn = true;
			echo '{"login":"S"}';
			include('connectdbcustom.php');	
			$query = "INSERT INTO PASSESAPP (FKidUsuario, cTipoSO, dFAcceso) 
							SELECT idUsuario, 1, NOW()
							FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			if (mysql_query($query,$cnnDBCUSTOM)){
				$close_cnn = true;
				}
				if ($close_cnn) {
					mysql_close($cnnDBCUSTOM);
				}
		}else{
			echo '{"login":"N"}';
		}
	}

?>