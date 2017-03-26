<?php header('Content-type: application/json; charset=utf-8');

	if ((isset($_GET['usr'])) && (isset($_GET['pwd'])) && (isset($_GET['ce'])) ) {
		include('funciones.php');

		$usr = $_GET['usr'];
		$pwd = $_GET['pwd'];
		$ce = $_GET['ce'];
		$error = false;

		if (!$error){
			$logueado = login($usr,$pwd,$ce);
			if ($logueado) {
				include('connectdbcustom.php');
				$query = "DELETE FROM PARRESPAPP 
							WHERE `FKidAsistencia`=137 OR 
							`FKidCalificacion`=21 OR
							`FKidTareas`=14";
				if (mysql_query($query,$cnnDBCUSTOM)) {
					echo 'REGISTROS BORRADOS - RECUERDA QUE ESTO BORRA LOS 3 REGISTROS ASISTENCIAS-TAREAS-CALIFICACIONES';
				} else {
					echo 'NO SE PUDO BORRAR LOS REGISTROS';
				}
					}
			}else{
				echo '{"login":"N"}';
			}
		}else{

			echo '{"login":"N"}';
		}
	

?>