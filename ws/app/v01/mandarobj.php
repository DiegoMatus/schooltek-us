
<?php

  //session_start();
require_once 'general.php';
//$_SESSION['foo'] = new General('kelpielovego0d@gmail.com','kelpie1990','ECCC','l','gen','1');
	$a= new General('kelpielovego0d@gmail.com','kelpie1990','ECCC','l','gen','1');
 $s = serialize($a);
  // almacenamos $s en algún lugar en el que page2.php puede encontrarlo.
  file_put_contents('calificacion.txt', $s);
  //echo $s;
?>
<a href="ejecutar.php?s=<?php echo $s?>">Mandar el objeto a Ejecutar.php</a>