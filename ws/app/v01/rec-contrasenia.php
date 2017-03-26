<?php header('Content-type: application/json; charset=utf-8');


	if ((isset($_GET['usr'])) && (isset($_GET['ce']))) {
		$usr = $_GET['usr'];
		$ce = $_GET['ce'];
		include('funciones.php');
		
		if (verificarUsuario($usr,$ce)){
			
			include('connectdblogin.php');
			
			$contraseniaRECTMP = generaPass();
			
			//Crear la contraseña
			$opciones = [
				'cost' => 12,
			];
			$contraseniaREC = password_hash($contraseniaRECTMP, PASSWORD_BCRYPT, $opciones);
			//FIN Crear la contraseña
			
			$query = "UPDATE GCSUSUARIO  SET sContrasenia='".$contraseniaREC."', sContraseniaTmp='".$contraseniaRECTMP."'
			WHERE sIDColegio='".$ce."' AND sCuenta='".$usr."'";
			
			if (mysql_query($query,$cnnDBLOGIN)) 
			{	
				include('connectdbcustom.php');
					$query = "UPDATE PCSUSUARIO  SET sContrasenia='".$contraseniaREC."', sContraseniaTmp='".$contraseniaRECTMP."'
					WHERE sCuenta='".$usr."'";
					
					if (mysql_query($query,$cnnDBCUSTOM)) 
					{
						if(enviaCorreo($contraseniaRECTMP,$usr,$ce))
						{
							echo '{"password":"S","estado":"1","mensaje":"Se ha enviado un correo con su nueva contraseña de acceso a Schooltek."}';
						}else{
							echo '{"password":"S","estado":"1","mensaje":"Se ha cambiado la contraseña, pero ha ocurrido un error al enviar el correo. Por favor inténtelo nuevamente."}';
						}
					}else{
						echo '{"password":"N","estado":"2","mensaje":"Ha ocurrido un error al intentar modificar la contraseña. Por favor inténtelo nuevamente."}';
					}
				
			}else{
				echo '{"password":"N","estado":"2","mensaje":"Ha ocurrido un error al intentar modificar la contraseña. Por favor inténtelo nuevamente."}';
			
			}
		}else{
			/*
			$cnnDBLOGIN=mysql_connect("localhost","abejoa5_aPROD","aP=n)9c%^sMaDtF");
			mysql_select_db("abejoa5_ST_PROD_LOGIN",$cnnDBLOGIN) or die ("Cannot connect the Database");
			mysql_query("SET NAMES 'utf8'",$cnnDBLOGIN); 
			$query = "SELECT A.sMACBD FROM GCSUSUARIO U INNER JOIN GCBDBACCESS A ON U.FKidDBAccess=A.idDBAccess WHERE U.sIDColegio='".$ce."' AND U.sCuenta='".$usr."'";
			$sqlcode = mysql_query($query,$cnnDBLOGIN);
			$rows = mysql_num_rows($sqlcode);
			//$row = mysql_fetch_array($sqlcode);
			//$db_name=$row["sMACBD"];
			mysql_close($cnnDBLOGIN);

			if ($rows < 1) {*/
				echo '{"password":"N","estado":"0","mensaje":"El Usuario o Colegio no existe, revise que sus datos estén escritos correctamente."}';
			/*}else{
				echo '{"password":"N","estado":"2","mensaje":"Aún no se ha activado su cuenta, contacte al administrador de su Colegio."}';
			}	*/
		}

	}else{
		// Falta alguno de los parámetros
		echo '{"password":"N"}';
	}
	
	function enviaCorreo($contraseniaREC,$usr,$ce){	
			$to  = $usr. ',';
			$subject = 'Schooltek - Solicitud de cambio de contraseña';
			$message = '
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Registro Schooltek</title>
				</head>
				<body>
					<table>
						<tr>
							<td>
								<h2>Cambio de contraseña de Schooltek </h2>
							</td>
						</tr>
						<tr >
							<td>
								Un cambio de contraseña ha sido solicitado desde su cuenta.
							</td>
						</tr>
						<tr>
							<td>
								Estos son sus nuevos datos de acceso:
							</td>
						</tr>
						<tr >
							<td>
								<b>Usuario:</b>&nbsp;'.$usr.'
							</td>
						</tr>
						<tr >
							<td>
								<b>Password:</b>&nbsp;'.$contraseniaREC.'
							</td>
						</tr>
						<tr >
							<td>
								<b>ID Colegio:</b>&nbsp;'.$ce.'
							</td>
						</tr>
					</table>
				</body>
			</html>
			';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Schooltek <no-reply@schooltek.com>' . "\r\n";
			$headers .= 'Bcc: aroldoprg@gmail.com' . ',';
			$headers .= 'Bcc: kelpielovego0d@gmail.com' . ',';
			if (mail($to, $subject, $message, $headers))
			{
				return true;
			}else{
				return false;
			}
	}


?>
