<?php
	
	function saveOptionT(&$cnnDBCUSTOMFUN, $usr, $option, $perfil){			
		if ($perfil="T") {	
			$query = "INSERT INTO PASOPCAPP  (FKidUsuario, FKidOpcion, dFOpcApp) 
			SELECT idUsuario, (SELECT idOpciones FROM PACOPCION WHERE cTipoOpcion='".$option."'), NOW()
			FROM PCSUSUARIO 
			WHERE sCuenta='".$usr."'";
			
			if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				$query = "UPDATE PACOPCION SET nConTuto=nConTuto+1 WHERE cTipoOpcion='".$option."'";
				mysql_query($query,$cnnDBCUSTOMFUN);
			} 
		}else{
			if ($perfil="P")
			{
				$query = "INSERT INTO PASOPCAPP  (FKidUsuario, FKidOpcion, dFOpcApp) 
				SELECT idUsuario, (SELECT idOpciones FROM PACOPCION WHERE cTipoOpcion='".$option."'), NOW()
				FROM PCSUSUARIO 
				WHERE sCuenta='".$usr."'";
			
				if (mysql_query($query,$cnnDBCUSTOMFUN)) {
					$query = "UPDATE PACOPCION SET nConProf=nConProf+1 WHERE cTipoOpcion='".$option."'";
					mysql_query($query,$cnnDBCUSTOMFUN);
				}
			}
		}		
	}
	

	function respApp(&$cnnDBCUSTOMFUN, $usr, $id, $r, $opcApp){
		if ($opcApp=="t-asistencias"){
			$query = "INSERT INTO PARRESPAPP (FKidAsistencia, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				echo '{"login":"S","success":"S"}';
			} else {
				echo '{"login":"S","success":"N"}';
			}*/
		}else if ($opcApp=="t-avisos"){
			$query = "INSERT INTO PARRESPAPP (FKidMensAvi, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				echo '{"login":"S","success":"S"}';
			} else {
				echo '{"login":"S","success":"N"}';
			}*/
		}else if ($opcApp=="t-alertas"){
				$query = "INSERT INTO PARRESPAPP (FKidAlerta, FKidUsuario, cTipoRespuesta, dFRespuesta) 
							SELECT '".$id."',idUsuario, '".$r."', NOW()
							FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
				/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
					echo '{"login":"S","success":"S"}';
				} else {
					echo '{"login":"S","success":"N"}';
				}*/
		}else if ($opcApp=="t-calendario"){
			$query = "INSERT INTO PARRESPAPP (FKidEvento, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				echo '{"login":"S","success":"S"}';
			} else {
				echo '{"login":"S","success":"N"}';
			}*/
		}else if ($opcApp=="t-calificaciones"){
			$query = "INSERT INTO PARRESPAPP (FKidCalificacion, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				echo '{"login":"S","success":"S"}';
			} else {
				echo '{"login":"S","success":"N"}';
			}*/
		}else if ($opcApp=="t-tareas"){
			$query = "INSERT INTO PARRESPAPP (FKidTareas, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
			/*if (mysql_query($query,$cnnDBCUSTOMFUN)) {
				echo '{"login":"S","success":"S"}';
			} else {
				echo '{"login":"S","success":"N"}';
			}*/
		}
		if (mysql_query($query,$cnnDBCUSTOMFUN)) {
			echo '{"login":"S","success":"S"}';
		} else {
			echo '{"login":"S","success":"N"}';
		}
	}

?>