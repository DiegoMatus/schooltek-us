<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$logueado = login($usr,$pwd,$ce);
		if ($logueado) {
			include('connectdbcustom.php');
			$row_array = array();
			$query = "SELECT DISTINCT P.cTipPerfil idPerfil, P.sPerfil Perfil FROM PCSUSUARIO U
						INNER JOIN PCRUSUAPERF R ON R.FKidUsuario=U.idUsuario
						INNER JOIN PCSPERFIL P ON P.idPerfil=R.FKidPerfil
						WHERE U.sCuenta='".$usr."'";
			$sqlcode = mysql_query($query,$cnnDBCUSTOM);
			while ($row = mysql_fetch_array($sqlcode)) {
				$r = new stdClass();
				$r->idPerfil = $row["idPerfil"];
				$r->Perfil = $row["Perfil"];
				$row_array[] = $r;
			}
			$params = array("login"=>"S","perfiles"=>$row_array);
			$jsonStr = json_encode($params);
			echo $jsonStr;
			mysql_close($cnnDBCUSTOM);
		}else{
			echo '{"login":"N"}';
		}			
	}else{
		echo '{"login":"N"}';
	}

?>