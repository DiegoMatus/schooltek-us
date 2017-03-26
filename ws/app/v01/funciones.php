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
	
	function verificarUsuario($usuario,$centeduc){
		include('connectdblogin.php');

		$query = "SELECT 'X' 
					FROM GCSUSUARIO U 
					INNER JOIN GCBDBACCESS A ON U.FKidDBAccess = A.idDBAccess
					WHERE U.sCuenta='".$usuario."' AND A.sIDColegio='".$centeduc."'";
		$sqlcode = mysql_query($query,$cnnDBLOGIN);
		$rows = mysql_num_rows($sqlcode);
		mysql_close($cnnDBLOGIN);
		if ($rows >= 1) {
			return true;
		}else{
			return false;
		}
	}
	
	function generaPass(){
		//Se define una cadena de caractares. Te recomiendo que uses esta.
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		//Obtenemos la longitud de la cadena de caracteres
		$longitudCadena=strlen($cadena);
		 
		//Se define la variable que va a contener la contraseña
		$pass = "";
		//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
		$longitudPass=8;
		 
		//Creamos la contraseña
		for($i=1 ; $i<=$longitudPass ; $i++){
			//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos=rand(0,$longitudCadena-1);
		 
			//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;
	}


	function br2nl($text) {
 		return preg_replace('/<br(\s+)?\/?>/i', "\n", $text);
	}


	function cleanText($text) {
		$text = preg_replace('/<br(\s+)?\/?>/i', "\n", $text);
 		$text = preg_replace('/&nbsp;/', " ", $text);
 		return $text;
	}

?>