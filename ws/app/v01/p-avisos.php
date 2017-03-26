<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) && (isset($_GET['gpo'])) && (isset($_GET['op']))) {
		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$gpo = $_GET['gpo'];
		$op = $_GET['op'];
		$error = false;
		if ($op=="alm") {
			if ((isset($_GET['mat']))){
				$mat=$_GET['mat'];
			}else{
				$error = true;
			}
		}else{
			if ($op=="det") {
				if ((isset($_GET['avi']))){
					$avi=$_GET['avi'];
				}else{
					$error = true;
				}
			}	
		}
		if (!$error){
			if ($usr=="profesor@gmail.mx" && $pwd=="345678" && $ce=="ECCC")
			{
				switch ($op){
					case "mat" :
						echo '{"login":"S","materias":[{"idMateria":"10","Materia":"Español"},{"idMateria":"20","Materia":"Matemáticas"},{"idMateria":"30","Materia":"Ciencias Naturales"}]}';
						break;
					case "alm" :
						echo '{"login":"S","alumnos":[{"idAlumno":"1","Nombre":"Alejandro Ulises","Apellidos":"Arrez Méndez"},{"idAlumno":"2","Nombre":"Carlos Mauricio","Apellidos":"González Hernández"},{"idAlumno":"3","Nombre":"Luis Fernando","Apellidos":"González Hernández"},{"idAlumno":"4","Nombre":"César Augusto","Apellidos":"Martínez Pedroza"}]}';
						break;
					case "new" :
						echo '{"login":"S","success":"S"}';
						break;
					case "his" :
						echo '{"login":"S","avisos":[{"idAviso":"20","Titulo":"Llevar revistas para recortar","Fecha":"16/01/2015","Materia":"Español"},{"idAviso":"21","Titulo":"Salida al museo","Fecha":"17/01/2015","Materia":"Ciencias Naturales"},{"idAviso":"22","Titulo":"No asistiré el prox. viernes","Fecha":"18/02/2015","Materia":""}]}';
						break;
					case "det" :
						switch ($avi) {
							case 20:
								echo '{"login":"S","aviso":{"Titulo":"Llevar revistas para recortar","Fecha":"16/01/2015","Contenido":"Llevar al menos 3 revistas para recortar, tijeras sin puntas y pegamento para realizar el trabajo final.","Materia":"Español"}}';
								break;
							case 21:
								echo '{"login":"S","aviso":{"Titulo":"Proyecto Herbolario","Fecha":"17/02/2015","Contenido":"Contenido del Proyecto Herbolario.","Materia":"Ciencias Naturales"}}';
								break;
							case 22:
								echo '{"login":"S","aviso":{"Titulo":"Operaciones de Álgebra","Fecha":"18/02/2015","Contenido":"Contenido de las Operaciones de Álgebra.","Materia":"Matemáticas"}}';
								break;
						}						
						break;
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