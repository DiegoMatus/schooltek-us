<?php header('Content-type: application/json; charset=utf-8');
		$error = false;
		try {
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$usr = $obj->usr;
			$pwd = $obj->pwd;
			$ce = $obj->ce;
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
				$logueado = login($usr,$pwd,$ce);
				if ($logueado) 
				{
					include('connectdbcustom.php');
					include('funcionesdb.php');
					$row_array = array();
					$query = "SELECT DISTINCT (G.idGradGrup) idGrupo, E.sDNivelEduc nivel, CONCAT(G.nGrado, ' ', G.sGrupo) grupo
										FROM PCSUSUARIO U
										INNER JOIN PCRGRUPROF R ON R.FKidPersonal=U.FKidPersonal
										INNER JOIN PCBGRADGRUP G ON G.idGradGrup=R.FKidGradGrup
										INNER JOIN PCBNIVEL N ON N.idNivel=G.FKidNivel
										INNER JOIN PCVNIVELEDUC E ON E.idNivelEduc=N.FKidNivelEduc
										WHERE U.sCuenta='".$usr."'";
					$sqlcode = mysql_query($query,$cnnDBCUSTOM);
					while ($row = mysql_fetch_array($sqlcode)) {
						$r = new stdClass();
						$r->idGrupo = $row["idGrupo"];
						$r->nivel = $row["nivel"];
						$r->grupo = $row["grupo"];
						$row_array[] = $r;
					}
					$params = array("login"=>"S","grupos"=>$row_array);
					$jsonStr = json_encode($params);
					echo $jsonStr;
				}else{
					echo '{"login":"N"}';
				}
			}else{
				echo '{"login":"N"}';
			}
		}


?>