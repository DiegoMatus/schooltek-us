<?php

	$cnnDBLOGIN=mysql_connect("localhost","abejoa5_aPROD","aP=n)9c%^sMaDtF");
	mysql_select_db("abejoa5_ST_PROD_LOGIN",$cnnDBLOGIN) or die ("Cannot connect the Database");
	mysql_query("SET NAMES 'utf8'",$cnnDBLOGIN); 
	$query = "SELECT A.sMACBD FROM GCSUSUARIO U INNER JOIN GCBDBACCESS A ON U.FKidDBAccess=A.idDBAccess WHERE U.sIDColegio='".$ce."' AND U.sCuenta='".$usr."'";
	$sqlcode = mysql_query($query,$cnnDBLOGIN);
	$row = mysql_fetch_array($sqlcode);
	$db_name=$row["sMACBD"];
	mysql_close($cnnDBLOGIN);

	$hostname="localhost";
	$username="abejoa5_aPROD";
	$password="aP=n)9c%^sMaDtF"; 
	$cnnDBCUSTOM=mysql_connect($hostname,$username,$password);
	mysql_select_db($db_name,$cnnDBCUSTOM) or die ("Cannot connect the Database");
	mysql_query("SET NAMES 'utf8'",$cnnDBCUSTOM);

?>