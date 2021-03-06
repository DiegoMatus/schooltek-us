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
				include('funcionesdb.php');
				$row_array = array();
				$close_cnn = false;
				switch ($op) {
					case "gen" :
						saveOptionT($cnnDBCUSTOM,$usr,"A","T");
						$query = "SELECT DISTINCT(L.idAsistencia) Id, L.cTipoAsistencia Asist, DATE_FORMAT(L.dFAsistencia,'%d-%m-%Y') Fecha
										FROM PCSUSUARIO U 
										INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
										INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
										INNER JOIN PCRASISTENCIA L ON L.FKidGradGrup=A.FKidGradGrup AND L.FKidAlumno=A.idAlumno
										WHERE L.cTipoAsistencia IN ('R', 'I') AND U.sCuenta='".$usr."'
										AND R.FKidAlumno='".$alm."'
										ORDER BY L.dFAsistencia DESC";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->Id = $row["Id"];
							$r->Asist = $row["Asist"];
							$r->Fecha = $row["Fecha"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S", "indmat"=>"N", "asistencias"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;								
						//echo '{"login":"S","indmat":"N","asistencias":[{"Id":"200","Asist":"I","Fecha":"01/10/2014"},{"Id":"201","Asist":"R","Fecha":"02/10/2014"}]}';
						$close_cnn = true;
						break;

					case "det" :
						saveOptionT($cnnDBCUSTOM,$usr,"AD","T");					
						$query = "SELECT L.idAsistencia Id, M.sDMateria Materia, L.cTipoAsistencia Asist, DATE_FORMAT(L.dFAsistencia,'%d-%m-%Y') Fecha, L.sComentarios Contenido, CASE WHEN R.cTipoRespuesta IS NULL THEN '' ELSE R.cTipoRespuesta END Resp
									FROM PCRASISTENCIA L 
									INNER JOIN PCVMATERIA M ON M.idMateria=L.FKidMateria
									LEFT JOIN PARRESPAPP R ON R.FKidAsistencia=L.idAsistencia
									WHERE L.idAsistencia='".$id."'
								UNION
								SELECT L.idAsistencia Id, M.sDCampoFor Materia, L.cTipoAsistencia Asist, DATE_FORMAT(L.dFAsistencia,'%d-%m-%Y') Fecha, L.sComentarios Contenido, CASE WHEN R.cTipoRespuesta IS NULL THEN '' ELSE R.cTipoRespuesta END Resp
									FROM PCRASISTENCIA L 
									INNER JOIN PCVCAMPOFOR M ON M.idCampoFor=L.FKidCampoFor
									LEFT JOIN PARRESPAPP R ON R.FKidAsistencia=L.idAsistencia
									WHERE L.idAsistencia='".$id."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						$row = mysql_fetch_array($sqlcode);
						$r = new stdClass();
						$r->Id = $row["Id"];
						$r->Materia = $row["Materia"];
						$r->Asist = $row["Asist"];
						$r->Fecha = $row["Fecha"];
						$r->Contenido = $row["Contenido"];
						$r->Resp = $row["Resp"];
						$params = array("login"=>"S", "indmat"=>"S", "asistencia"=>$r);
						$jsonStr = json_encode($params);
						echo $jsonStr;
						//echo '{"login":"S","indmat":"S","asistencia":{"Id":"201","Materia":"Español","Asist":"R","Fecha":"01/10/2014","Contenido":"Estaba jugando y entró tarde al salón"}}';
						$close_cnn = true;
						break;

					case "res" :
						respApp($cnnDBCUSTOM,$usr, $id, $r, 't-asistencias');
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