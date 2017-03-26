<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) && (isset($_GET['alm'])) && (isset($_GET['op']))) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$alm = $_GET['alm'];
		$op = $_GET['op'];
		$error = false;
		if ($op=="det") {
			if ((isset($_GET['tip']))){
				$tip=$_GET['tip'];
					if ((isset($_GET['id']))){
						$id=$_GET['id'];
					}else{
						$error = true;
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
						case "mat" :
							$query = "SELECT DISTINCT M.idMateria Id, M.sDMateria Materia, 'M' Tipo
											FROM PCSUSUARIO U 
											INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
											INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
											INNER JOIN PCRHORARIO H ON H.FKidGradGrup=A.FKidGradGrup
											INNER JOIN PCVMATERIA M ON M.idMateria=H.FKidMateria
											WHERE H.cIndActivo='S' AND A.idAlumno='".$alm."' AND U.sCuenta='".$usr."'";
							$sqlcode = mysql_query($query,$cnnDBCUSTOM);
							while ($row = mysql_fetch_array($sqlcode)) {
								$r = new stdClass();
								$r->Id = $row["Id"];
								$r->Materia = $row["Materia"];
								$r->Tipo = $row["Tipo"];
								$row_array[] = $r;
							}
							$params = array("login"=>"S", "materias"=>$row_array);
							$jsonStr = json_encode($params);
							echo $jsonStr;
							$close_cnn = true;
							break;
							
						case "dia" :
						echo '{"login":"S","dias":[{"Id":"1","Dia":"LUNES"},{"Id":"2","Dia":"MARTES"},{"Id":"3","Dia":"MIÉRCOLES"},{"Id":"4","Dia":"JUEVES"},{"Id":"5","Dia":"VIERNES"}]}';
						break;
						
						case "det" :
							if ($tip=='M'){
								$query = "SELECT CASE WHEN H.nDiaSemana=1 THEN 'LUNES'
											WHEN H.nDiaSemana=2 THEN 'MARTES'
											WHEN H.nDiaSemana=3 THEN 'MIÉRCOLES'
											WHEN H.nDiaSemana=4 THEN 'JUEVES'
											WHEN H.nDiaSemana=5 THEN 'VIERNES' END Dia, M.sDMateria Materia, CONCAT (DATE_FORMAT(H.dHInicio, '%H:%S'), ' - ',DATE_FORMAT(H.dHFin, '%H:%S'), ' hrs.') Hora
											FROM PCSUSUARIO U 
											INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
											INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
											INNER JOIN PCRHORARIO H ON H.FKidGradGrup=A.FKidGradGrup
											INNER JOIN PCVMATERIA M ON M.idMateria=H.FKidMateria
											WHERE H.cIndActivo='S' AND A.idAlumno='".$alm."' AND U.sCuenta='".$usr."' AND M.idMateria='".$id."'";
							}else{
								$query = "SELECT  CASE WHEN H.nDiaSemana=1 THEN 'LUNES'
											WHEN H.nDiaSemana=2 THEN 'MARTES'
											WHEN H.nDiaSemana=3 THEN 'MIÉRCOLES'
											WHEN H.nDiaSemana=4 THEN 'JUEVES'
											WHEN H.nDiaSemana=5 THEN 'VIERNES' END Dia, M.sDMateria Materia, CONCAT (DATE_FORMAT(H.dHInicio, '%H:%S'), ' - ',DATE_FORMAT(H.dHFin, '%H:%S'), ' hrs.') Hora
											FROM PCSUSUARIO U 
											INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
											INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
											INNER JOIN PCRHORARIO H ON H.FKidGradGrup=A.FKidGradGrup
											INNER JOIN PCVMATERIA M ON M.idMateria=H.FKidMateria
											WHERE H.cIndActivo='S' AND A.idAlumno='".$alm."' AND U.sCuenta='".$usr."' AND H.nDiaSemana='".$id."'";
								
							}							
							$sqlcode = mysql_query($query,$cnnDBCUSTOM);
							while ($row = mysql_fetch_array($sqlcode)) {
								$r = new stdClass();
								$r->Dia = $row["Dia"];
								$r->Materia = $row["Materia"];
								$r->Hora = $row["Hora"];
								$row_array[] = $r;
							}
							$params = array("login"=>"S", "horarios"=>$row_array);
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
			echo '{"login":"N"}';
		}
	}else{
		echo '{"login":"N"}';
	}

?>