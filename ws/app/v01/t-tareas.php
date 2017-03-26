<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) && (isset($_GET['alm'])) && (isset($_GET['op']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$alm = $_GET['alm'];
		$op = $_GET['op'];
		$error = false;
		if ($op=="det" || $op=="res" || $op=="des") {
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
				switch ($op){
					case "gen" :
						saveOptionT($cnnDBCUSTOM,$usr,"T","T");
						$query = "SELECT DISTINCT T.idTarea Id, M.sDCMAteria Materia, T.sTitulo Titulo, DATE_FORMAT(T.dFEntrega,'%d-%m-%Y') Fecha
									FROM PCSUSUARIO U 
									INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor   
									INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
									INNER JOIN PCBGRADGRUP G ON A.FKidGradGrup=G.idGradGrup 
									LEFT JOIN PCBTAREAS T ON T.FKidGradGrup=G.idGradGrup
									INNER JOIN PCRPROFMAT P ON P.idRelProfMat=T.FKidRelProfMat
									INNER JOIN PCVMATERIA M ON M.idMateria=P.FKidMateria
									WHERE T.cIndActivo='S' AND U.sCuenta='".$usr."' 
								UNION
								SELECT DISTINCT T.idTarea Id, M.sDCampoFor Materia, T.sTitulo Titulo, DATE_FORMAT(T.dFEntrega,'%d-%m-%Y') Fecha
									FROM PCSUSUARIO U 
									INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor   
									INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
									INNER JOIN PCBGRADGRUP G ON A.FKidGradGrup=G.idGradGrup 
									LEFT JOIN PCBTAREAS T ON T.FKidGradGrup=G.idGradGrup
									INNER JOIN PCVCAMPOFOR M ON M.idCampoFor=T.FKidCampoFor
									WHERE T.cIndActivo='S' AND U.sCuenta='".$usr."' 
									";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->Id = $row["Id"];
							$r->Materia = $row["Materia"];
							$r->Titulo = $row["Titulo"];
							$r->Fecha = $row["Fecha"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S", "tareas"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;
						$close_cnn = true;
						break;

					case "det" :
						saveOptionT($cnnDBCUSTOM,$usr,"TD","T");
						$query = "SELECT T.idTarea Id, M.sDCMAteria Materia, T.sTitulo Titulo, DATE_FORMAT(T.dFEntrega,'%d-%m-%Y') Fecha, T.sDTarea Contenido, CASE WHEN TRIM(IFNULL(sNomArchivo,'')) = '' THEN '[Sin Archivo]' ELSE CONCAT(sNomArchivo,sExtArchivo) END File, CASE WHEN R.cTipoRespuesta IS NULL THEN '' ELSE R.cTipoRespuesta END Resp
									FROM PCBTAREAS T
									INNER JOIN PCRPROFMAT P ON P.idRelProfMat=T.FKidRelProfMat
									INNER JOIN PCVMATERIA M ON M.idMateria=P.FKidMateria
									LEFT JOIN PARRESPAPP R ON R.FKidTareas=T.idTarea
									WHERE T.cIndActivo='S' AND T.idTarea='".$id."'
									UNION
								SELECT T.idTarea Id,  M.sDCampoFor Materia, T.sTitulo Titulo, DATE_FORMAT(T.dFEntrega,'%d-%m-%Y') Fecha, T.sDTarea Contenido, CASE WHEN TRIM(IFNULL(sNomArchivo,'')) = '' THEN '[Sin Archivo]' ELSE CONCAT(sNomArchivo,sExtArchivo) END File, CASE WHEN R.cTipoRespuesta IS NULL THEN '' ELSE R.cTipoRespuesta END Resp
									FROM PCBTAREAS T
									INNER JOIN PCVCAMPOFOR M ON M.idCampoFor=T.FKidCampoFor
									LEFT JOIN PARRESPAPP R ON R.FKidTareas=T.idTarea
									WHERE T.cIndActivo='S' AND T.idTarea='".$id."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						$row = mysql_fetch_array($sqlcode);
						$r = new stdClass();
						$r->Id = $row["Id"];
						$r->Materia = $row["Materia"];
						$r->Titulo = $row["Titulo"];
						$r->Fecha = $row["Fecha"];
						$r->Contenido = $row["Contenido"];
						$r->File = $row["File"];
						$r->Resp = $row["Resp"];
						$params = array("login"=>"S", "tarea"=>$r);
						$jsonStr = json_encode($params);
						echo $jsonStr;
						$close_cnn = true;
						break;

					case "res" :
						respApp($cnnDBCUSTOM,$usr, $id, $r, 't-tareas');
						$close_cnn = true;
						break;
						
					case "des" :
						$query = "SELECT bArchAdjuntos, sNomArchivo, sTipArchivo
									FROM PCBTAREAS
									WHERE sNomArchivo<>'[Sin Archivo]' AND idTarea='".$id."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						$rows = mysql_num_rows($sqlcode);
						if($rows>0) {
							//$extensiones = array("application/msword"=>"doc","application/pdf"=>"pdf","image/jpeg"=>"jpg", "application/rar"=>"rar");
							$extensiones = array("application/pdf"=>"pdf");
							$contenido = mysql_result($sqlcode, 0, "bArchAdjuntos");
							$nombre = mysql_result($sqlcode, 0, "sNomArchivo");
							$tipo = mysql_result($sqlcode, 0, "sTipArchivo");
							//header("Content-type: ".$tipo."");
							//header('Content-disposition: attachment; filename="'.$nombre.'.'.$extensiones[$tipo].'"');
							header('Content-type: application/pdf');
							header('Content-disposition: attachment; filename="'.$nombre.'.pdf');
							echo $contenido;
						}else{
							echo '{"login":"S","file":"N"}';
						}
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
	}else{
		// Falta alguno de los parámetros
		echo '{"login":"N"}';
	}

?>