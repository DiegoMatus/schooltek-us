<?php header('Content-type: application/json; charset=utf-8');
	$error = false;
	try {
		$json = file_get_contents('php://input');
		$obj = json_decode($json);
		$usr = $obj->pwd;
		$pwd = $obj->ce;
		$ce = $obj->ce;
		$gpo = $obj->gpo;
		$op = $obj->op;
		
		if ($op=="det") {
			$alm = $obj->alm;
			if ($alm==""){
				$error = true;
			}
		}
		
	} catch (Exception $e) {
		$error = true;
	}
	if ($error)
	{
		echo '{"login":"N"}';
	}else{
		if($usr!="" && $pwd !="" && $ce!="")
		{
			include('funciones.php');
			if ($logueado) {
				include('connectdbcustom.php');
				include('funcionesdb.php');
				$row_array = array();
				switch ($op){
				case "gen" :
					saveOptionT($cnnDBCUSTOM,$usr,"A","P");
					$query = "SELECT A.idAlumno idAlumno, A.sNombre nombre, CONCAT(A.sApPaterno, ' ', A.sApMAterno) apellidos
										FROM PCBALUMNO A
										WHERE A.FKidGradGrup='".$gpo."'";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					while ($row = mysql_fetch_array($sqlcode)) {
						$r = new stdClass();
						$r->idAlumno = $row["idAlumno"];
						$r->nombre = $row["nombre"];
						$r->apellidos = $row["apellidos"];
						$row_array[] = $r;
					}
					$params = array("login"=>"S","alumnos"=>$row_array);
					$jsonStr = json_encode($params);
					echo $jsonStr;					
				break;
				case "det" :	
					saveOptionT($cnnDBCUSTOM,$usr,"AD","P");	
					$query = "SELECT SUM(K.A)asist  , SUM(K.I) faltas, SUM(K.R) ret , K.FECHA mes
									FROM(SELECT 
										CASE WHEN L.cTipoAsistencia='A' THEN 1 ELSE 0 END A, 
										CASE WHEN L.cTipoAsistencia='I' THEN 1 ELSE 0 END I, 
										CASE WHEN L.cTipoAsistencia='R' THEN 1 ELSE 0 END R, 
										CASE   
										 WHEN MONTH(L.dFAsistencia)=1 THEN 'ENERO'
										 WHEN MONTH(L.dFAsistencia)=2 THEN 'FEBRERO'
										 WHEN MONTH(L.dFAsistencia)=3 THEN 'MARZO'
										 WHEN MONTH(L.dFAsistencia)=4 THEN 'ABRIL'
										 WHEN MONTH(L.dFAsistencia)=5 THEN 'MAYO'
										 WHEN MONTH(L.dFAsistencia)=6 THEN 'JUNIO'
										 WHEN MONTH(L.dFAsistencia)=7 THEN 'JULIO'
										 WHEN MONTH(L.dFAsistencia)=8 THEN 'AGOSTO'
										 WHEN MONTH(L.dFAsistencia)=9 THEN 'SEPTIEMBRE'
										 WHEN MONTH(L.dFAsistencia)=10 THEN 'OCTUBRE'
										 WHEN MONTH(L.dFAsistencia)=11 THEN 'NOVIEMBRE'
										 WHEN MONTH(L.dFAsistencia)=12 THEN 'DICIEMBRE'
										 END FECHA 
										FROM PCBALUMNO A 
										INNER JOIN PCRASISTENCIA L ON L.FKidAlumno=A.idAlumno 
										WHERE A.idAlumno='".$alm."') K GROUP BY K.FECHA";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					while ($row = mysql_fetch_array($sqlcode)) {
						$r = new stdClass();
						$r->mes = $row["mes"];
						$r->asist = $row["asist"];
						$r->faltas = $row["faltas"];
						$r->ret = $row["ret"];
						$row_array[] = $r;
					}
					$params = array("login"=>"S","asistencia"=>$row_array);
					$jsonStr = json_encode($params);
					echo $jsonStr;
					break;
				}
				
				
			}else{	
			echo '{"login":"N"}';
			}
		}else{
		echo '{"login":"N"}';
		}
	}
	

?>