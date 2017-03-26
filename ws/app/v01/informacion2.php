<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) && (isset($_GET['op']))) {
		include('funciones2.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$op = $_GET['op'];
		
		$logueado = login($usr,$pwd,$ce);
		if ($logueado) {
			include('connectdbcustom2.php');
			$row_array = array();
			$r = new stdClass();
			$close_cnn = false;
			switch ($_GET['op']) {
				case "ms" :
					saveOptionT($usr,"IM","T");	
					$query = "SELECT sMision, sVision FROM PCBCENTROEDUC";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					$row = mysql_fetch_array($sqlcode);
					$r->login = "S";
					$r->mision = cleanText($row["sMision"]);
					$r->vision = cleanText($row["sVision"]);
					$jsonStr = json_encode($r);
					echo $jsonStr;					
					$close_cnn = true;
					break;

				case "val" :
					saveOptionT($usr,"IV","T");
					$query = "SELECT sValores FROM PCBCENTROEDUC";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					$row = mysql_fetch_array($sqlcode);
					$r->login = "S";
					$r->valores = cleanText($row["sValores"]);
					$jsonStr = json_encode($r);
					echo $jsonStr;
					$close_cnn = true;
					break;

				case "reg" :
					saveOptionT($usr,"IR","T");
					$query = "SELECT sReglamento FROM PCBCENTROEDUC";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					$row = mysql_fetch_array($sqlcode);
					$r->login = "S";
					$r->reglamento = cleanText($row["sReglamento"]);
					$jsonStr = json_encode($r);
					echo $jsonStr;
					$close_cnn = true;
					break;

				case "dir" :
					saveOptionT($usr,"ID","T");
					//$query = "SELECT CONCAT(sNombre,' ',IFNULL(sApPaterno,''),' ',IFNULL(sApMaterno,'')) Nombre, sTelCelular Telefono, CASE cTipoPers WHEN 'A' THEN 'Administrativo' WHEN 'D' THEN 'Director' WHEN 'P' THEN 'Profesor' WHEN 'S' THEN 'Subdirector' END Tipo FROM PCBPERSONAL WHERE cIndDirTelCel='S' ORDER BY Tipo Asc, Nombre Asc";
					//$query = "SELECT CONCAT(sNombre,' ',IFNULL(sApPaterno,''),' ',IFNULL(sApMaterno,'')) Nombre, CASE cIndDirTelCel WHEN 'S' THEN sTelCelular ELSE sTelPrivado END Telefono, CASE cTipoPers WHEN 'A' THEN 'Administrativo' WHEN 'D' THEN 'Director' WHEN 'P' THEN 'Profesor' WHEN 'S' THEN 'Subdirector' END Tipo FROM PCBPERSONAL WHERE cIndDirTelCel='S' OR cIndDirTelPriv='S' ORDER BY Tipo Asc, Nombre Asc";
					$query = "SELECT CONCAT(IFNULL(sApPaterno,''),' ',IFNULL(sApMaterno,''),', ',sNombre) Nombre, CASE cIndDirTelCel WHEN 'S' THEN sTelCelular ELSE sTelPrivado END Telefono, CASE cTipoPers WHEN 'A' THEN 'Administrativo' WHEN 'D' THEN 'Director' WHEN 'P' THEN 'Profesor' WHEN 'S' THEN 'Subdirector' END Tipo FROM PCBPERSONAL WHERE cIndDirTelCel='S' OR cIndDirTelPriv='S' ORDER BY Tipo Asc, Nombre Asc";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					while ($row = mysql_fetch_array($sqlcode)) {
						$r = new stdClass();
						$r->Nombre = $row["Nombre"];
						$r->Telefono = $row["Telefono"];
						$r->Tipo = $row["Tipo"];
						$row_array[] = $r;
					}
					$params = array("login"=>"S", "directorio"=>$row_array);
					$jsonStr = json_encode($params);
					echo $jsonStr;
					$close_cnn = true;
					break;
			}
			
			if ($close_cnn) {
				mysql_close($cnnDBCUSTOM);
			}
		}else{
			echo '{"login":"N"}';
		}
	}else{
		// Falta alguno de los parámetros
		echo '{"login":"N"}';
	}

?>