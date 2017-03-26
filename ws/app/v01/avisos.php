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
				if ($usr=="tutor@gmail.mx" && $pwd=="876543" && $ce=="ECCC")
				{
					switch ($op){
					case "gen" :
						echo '{"login":"S","avisos":[{"Id":"50","Titulo":"Semana del reciclaje","Fecha":"21/09/2014"},{"Id":"51","Titulo":"Nuevas disposiciones","Fecha":"25/09/2014"}]}';
						break;
					case "det" :
						echo '{"login":"S","aviso":{"Titulo":"Semana del reciclaje","Fecha":"21/09/2014","Contenido":"La entrega de botellas para reciclaje se llevará a cabo en el auditorio a las 16:30 hrs.","Resp":""}}';
						break;
					case "res" :
						echo '{"login":"S","success":"S"}';
						break;
					}
				}else{
					$close_cnn = false;
					switch ($op){
						case "gen" :
							$query = "SELECT DISTINCT M.idMensAvi Id, M.sDCMensajeAviso Titulo, DATE_FORMAT(M.dFAlta,'%d-%m-%Y') Fecha 
											FROM PCSUSUARIO U 
											INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
											INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
											INNER JOIN PCBGRADGRUP G ON A.FKidGradGrup=G.idGradGrup 
											INNER JOIN PCRMENSAVI R2 ON G.idGradGrup=R2.FKidGradGrup 
											INNER JOIN PCBMENSAVI M ON R2.FKidMensajeAviso=M.idMensAvi 
											WHERE M.cIndActivo='S' AND U.sCuenta='".$usr."'  ORDER BY M.dFUltModif DESC";
							$sqlcode = mysql_query($query,$cnnDBCUSTOM);
							while ($row = mysql_fetch_array($sqlcode)) {
								$r = new stdClass();
								$r->Id = $row["Id"];
								$r->Titulo = $row["Titulo"];
								$r->Fecha = $row["Fecha"];
								$row_array[] = $r;
							}
							$params = array("login"=>"S", "avisos"=>$row_array);
							$jsonStr = json_encode($params);
							echo $jsonStr;
							$close_cnn = true;
							break;

						case "det" :
							$query = "SELECT sDCMensajeAviso Titulo, DATE_FORMAT(dFAlta,'%d-%m-%Y') Fecha, sDMensajeAviso Contenido, 'S' Resp FROM PCBMENSAVI WHERE idMensAvi='".$id."'";
							$sqlcode = mysql_query($query,$cnnDBCUSTOM);
							$row = mysql_fetch_array($sqlcode);
							$r = new stdClass();
							$r->Titulo = $row["Titulo"];
							$r->Fecha = $row["Fecha"];
							$r->Contenido = $row["Contenido"];
							$r->Resp = $row["Resp"];
							$params = array("login"=>"S", "aviso"=>$r);
							$jsonStr = json_encode($params);
							echo $jsonStr;
							$close_cnn = true;
							break;

						case "res" :
							$query = "INSERT INTO PCRRESPAPP (FKidAsistencia, FKidUsuario, cTipoRespuesta, dFRespuesta) 
										SELECT '".$id."',idUsuario, '".$r."', NOW()
										FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
							if (mysql_query($query,$cnnDBCUSTOM)) {
								echo '{"login":"S","success":"S"}';
							} else {
								echo '{"login":"S","success":"N"}';
							}
							$close_cnn = true;
							break;
					}
					if ($close_cnn) {
						mysql_close($cnnDBCUSTOM);
					}
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