<?php
    $hostname="localhost";
    $username="abejoa5_aPROD";
    $password="aP=n)9c%^sMaDtF"; 
    $db_name="abejoa5_ST_PROD_LOGIN";
    $cnnDBLOGIN=mysql_connect($hostname,$username,$password);
    mysql_select_db($db_name,$cnnDBLOGIN) or die ("Cannot connect the Database");
    mysql_query("SET NAMES 'utf8'",$cnnDBLOGIN); 
?>