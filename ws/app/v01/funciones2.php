<?php

	function login($usuario,$password,$centeduc){
		include('connectdblogin.php');

		$query = "SELECT COUNT(*) AS login 
					FROM GCSUSUARIO U 
					INNER JOIN GCBDBACCESS A ON U.FKidDBAccess = A.idDBAccess
					WHERE U.sCuenta='".$usuario."' AND U.sContraseniaTmp='".$password."' AND A.sIDColegio='".$centeduc."'";
		$sqlcode = mysql_query($query,$cnnDBLOGIN);
		$rows = mysql_num_rows($sqlcode);
		mysql_close($cnnDBLOGIN);
		if ($rows >= 1) {
			return true;
		}else{
			return false;
		}
	}


	function br2nl($text) {
 		return preg_replace('/<br(\s+)?\/?>/i', "\n", $text);
	}


	function cleanText($text) {
		$text = preg_replace('/<br(\s+)?\/?>/i', "\n", $text);
 		$text = preg_replace('/&nbsp;/', " ", $text);
 		return $text;
	}

	
	function saveOptionT($usr, $option, $perfil){
		include('connectdbcustomfun.php');
				
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
		mysql_close($cnnDBCUSTOMFUN);
	}
	

	function respApp($usr, $id, $r, $opcApp){
		include('connectdbcustomfun.php');
		
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
		}else if ($opcApp=="t-alerta"){
			$query = "INSERT INTO PARRESPAPP (FKidAlerta, FKidUsuario, cTipoRespuesta, dFRespuesta) 
						SELECT '".$id."',idUsuario, '".$r."', NOW()
						FROM PCSUSUARIO WHERE sCuenta='".$usr."'";
		}
		if (mysql_query($query,$cnnDBCUSTOMFUN)) {
			echo '{"login":"S","success":"S"}';
		} else {
			echo '{"login":"S","success":"N"}';
		}
		mysql_close($cnnDBCUSTOMFUN);
	}

?>