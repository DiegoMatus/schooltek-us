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
			$query = "SELECT  DISTINCT(A.idAlumno) idAlum, CONCAT(A.sNombre, ' ', A.sApPaterno, ' ', A.sApMaterno) Nombre, E.sDNivelEduc Nivel, CONCAT(G.nGrado,' ',G.sGrupo) Grupo
									FROM PCSUSUARIO U 
									INNER JOIN PCRALUMTUTO R ON U.FKidTutor=R.FKidTutor 
									INNER JOIN PCBALUMNO A ON R.FKidAlumno=A.idAlumno 
									INNER JOIN PCBGRADGRUP G ON A.FKidGradGrup=G.idGradGrup 
									INNER JOIN PCBNIVEL N ON N.idNivel=G.FKidNivel
									INNER JOIN PCVNIVELEDUC E ON E.idNivelEduc=N.FKidNivelEduc
									INNER JOIN PCVPERIEVAL P ON P.FKidNivelEduc=E.idNivelEduc
									WHERE P.cIndActivo='S' AND U.sCuenta='".$usr."'";
			$sqlcode = mysql_query($query,$cnnDBCUSTOM);
			while ($row = mysql_fetch_array($sqlcode)) {
				$r = new stdClass();
				$r->idAlum = $row["idAlum"];
				$r->Nombre = $row["Nombre"];
				$r->Nivel = $row["Nivel"];
				$r->Grupo = $row["Grupo"];
				$row_array[] = $r;
			}
			$params = array("login"=>"S", "alumnos"=>$row_array);
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