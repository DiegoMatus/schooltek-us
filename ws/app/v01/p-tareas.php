<?php header('Content-type: application/json; charset=utf-8');

	$error = false;
	try {
		$json = file_get_contents('php://input');
		$obj = json_decode($json);
		$usr = $obj->usr;
		$pwd = $obj->pwd;
		$ce = $obj->ce;
		$op = $obj->op;
		if ($op=="alm") {
			$mat = $obj->mat;
			if ($mat==""){
				$error = true;
			}
		}else{
			
			if ($op=="det") {
				$tar = $obj->tar;
				if ($tar==""){
					$error = true;
				}
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
			$logueado = login($usr,$pwd,$ce);
			if ($logueado) 
			{
				include('connectdbcustom.php');
				include('funcionesdb.php');
				$row_array = array();
				switch ($op){
					case "mat" :
						$query = "SELECT DISTINCT M.idMateria idMateria, M.sDMateria Materia
									FROM PCSUSUARIO U
									INNER JOIN PCRGRUPROF R ON R.FKidPersonal=U.FKidPersonal
									INNER JOIN PCBGRADGRUP G ON G.idGradGrup=R.FKidGradGrup
									INNER JOIN PCRPROFMAT MT ON MT.FKidPersonal=U.FKidPersonal 
									INNER JOIN PCVMATERIA M ON M.idMateria=MT.FKidMateria
									WHERE U.sCuenta='".$usr."'
									AND G.idGradGrup='".$gpo."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->idMateria = $row["idMateria"];
							$r->Materia = $row["Materia"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S","grupos"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;	
						break;
					case "alm" :
						$query = "SELECT DISTINCT(A.idAlumno) idAlum, A.sNombre Nombre, CONCAT(A.sApPaterno, ' ', A.sApMaterno) Apellidos
									FROM PCBALUMNO A 
									WHERE A.FKidGradGrup='".$gpo."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->idMateria = $row["idMateria"];
							$r->Materia = $row["Materia"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S","alumnos"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;	
						break;
					case "new" :
						echo '{"login":"S","success":"S"}';
						break;
					case "his" :
						$query = "SELECT DISTINCT M.idMateria idMateria, M.sDMateria Materia
									FROM PCSUSUARIO U
									INNER JOIN PCRGRUPROF R ON R.FKidPersonal=U.FKidPersonal
									INNER JOIN PCBGRADGRUP G ON G.idGradGrup=R.FKidGradGrup
									INNER JOIN PCRPROFMAT MT ON MT.FKidPersonal=U.FKidPersonal 
									INNER JOIN PCVMATERIA M ON M.idMateria=MT.FKidMateria
									WHERE U.sCuenta='".$usr."'
									AND G.idGradGrup='".$gpo."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->idTarea = $row["idTarea"];
							$r->titulo = $row["titulo"];
							$r->fecha = $row["fecha"];
							$r->materia = $row["materia"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S","tareas"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;	
						//echo '{"login":"S","tareas":[{"idTarea":"10","Titulo":"Ensayo Oscar Wilde","Fecha":"16/02/2015","Materia":"Español"},{"idTarea":"11","Titulo":"Proyecto Herbolario","Fecha":"17/02/2015","Materia":"Ciencias Naturales"},{"idTarea":"12","Titulo":"Operaciones de Álgebra","Fecha":"18/02/2015","Materia":"Matemáticas"}]}';
						break;
					case "det" :
						$query = "SELECT DISTINCT  T.sTitulo titulo, T.dFEntrega fecha, T.sDTarea descrip, M.sDMateria materia
									FROM  PCBTAREAS T
									INNER JOIN PCRPROFMAT P ON P.idRelProfMat=T.FKidRelProfMat
									INNER JOIN PCVMATERIA M ON P.FKidMateria=M.idMateria
									WHERE T.cIndActivo='S' AND T.idTarea='".$tar."'";
						$sqlcode = mysql_query($query,$cnnDBCUSTOM);
						while ($row = mysql_fetch_array($sqlcode)) {
							$r = new stdClass();
							$r->titulo = $row["titulo"];
							$r->fecha = $row["fecha"];
							$r->descrip = $row["descrip"];
							$r->materia = $row["materia"];
							$row_array[] = $r;
						}
						$params = array("login"=>"S","tarea"=>$row_array);
						$jsonStr = json_encode($params);
						echo $jsonStr;	
					/*
						switch ($tar) {
							case 10:
								echo '{"login":"S","tarea":{"Titulo":"Ensayo Oscar Wilde","Fecha":"16/02/2015","Descrip":"Redactar un ensayo de 2 cuartillas sobre alguna de las lecturas vistas en clase de Oscar Wilde.","Materia":"Español"}}';
								break;
							case 11:
								echo '{"login":"S","tarea":{"Titulo":"Proyecto Herbolario","Fecha":"17/02/2015","Descrip":"Descripción del Proyecto Herbolario.","Materia":"Ciencias Naturales"}}';
								break;
							case 12:
								echo '{"login":"S","tarea":{"Titulo":"Operaciones de Álgebra","Fecha":"18/02/2015","Descrip":"Descripción de las Operaciones de Álgebra.","Materia":"Matemáticas"}}';
								break;
						}*/						
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