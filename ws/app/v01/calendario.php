<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) && (isset($_GET['alm'])) && (isset($_GET['op']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$alm = $_GET['alm'];
		$op = $_GET['op'];
		$error = false;
		if ($op=="det" || $op=="res") {
			if ((isset($_GET['id']))){
				$id=$_GET['id'];
				if ($op=="res") {
					if ((isset($_GET['r']))){
						$r=$_GET['r'];
					}else{
						$error = true;
					}
				}
			}else{
				$error = true;
			}
		}
		if (!$error){
			$logueado = login($usr,$pwd,$ce);
			if ($logueado) {
				include('connectdbcustom.php');
				$row_array = array();
				$close_cnn = false;
				switch ($op){
					case "gen" :
						saveOptionT($usr,"C","T");
						$query = "SELECT idEvento Id, sTituloEvento Titulo, DATE_FORMAT(dInicio,'%d-%m-%Y') Fecha FROM PCBCALEVENT WHERE cIndActivo='S' ORDER BY dInicio DESC";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
    						$r->Id = $row["Id"];
    						$r->Titulo = $row["Titulo"];
    						$r->Fecha = $row["Fecha"];
    						$row_array[] = $r;
						}
						$params = array("login"=>"S", "calendario"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;
						//echo '{"login":"S","calendario":[{"Id":"20","Titulo":"Entrega de calificaciones","Fecha":"21/09/2014"},{"Id":"21","Titulo":"Olimpiadas infantiles","Fecha":"25/09/2014"},{"Id":"22","Titulo":"Vacunación oficial","Fecha":"05/10/2014"}]}';
						$close_cnn = true;
						break;

					case "det" :
						saveOptionT($usr,"CD","T");
						$query = "SELECT idEvento Id, sTituloEvento Titulo, DATE(dInicio) Fecha, sDEvento Contenido, CASE WHEN R.cTipoRespuesta IS NULL THEN '' ELSE R.cTipoRespuesta END Resp
						FROM PCBCALEVENT E
						LEFT JOIN PARRESPAPP R ON R.FKidEvento=E.idEvento
						WHERE idEvento='".$id."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						$row = mysql_fetch_array($sqlcode);
						$r = new stdClass();
    					$r->Titulo = $row["Titulo"];
    					$r->Fecha = $row["Fecha"];
    					$r->Contenido = $row["Contenido"];
    					$r->Resp = $row["Resp"];
						$params = array("login"=>"S", "evento"=>$r);
						$jsonStr = json_encode($params);
						echo $jsonStr;
						//echo '{"login":"S","evento":{"Titulo":"Entrega de calificaciones","Fecha":"21/09/2014","Contenido":"La entrega de calificaciones se llevará a cabo en el auditorio a las 16:00 hrs.","Resp":""}}';
						$close_cnn = true;
						break;

					case "res" :
					respApp($usr, $id, $r, 't-calendario');
					/*
						$query = "INSERT INTO PCRRESPAPP (FKidAsistencia, FKidUsuario, cTipoRespuesta, dFRespuesta) 
									SELECT '".$id."',idUsuario, '".$r."', NOW()
									FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
						if (mysql_query($query,$cnnDBCUSTOM)) {
							echo '{"login":"S","success":"S"}';
						} else {
							echo '{"login":"S","success":"N"}';
						}*/
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
			echo '{"login":"N"}';
		}
	}else{
		echo '{"login":"N"}';
	}

?>