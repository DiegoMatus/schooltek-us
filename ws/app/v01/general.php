<?php
	class General
	{
		
		 /*var $Objeto; 

		function General(&$objeto) 
			{ 
				$this->Objeto =& $objeto; 
			}
			*/
			
     private $usr ;
     private $pwd ;
     private $ce ;
	private $alm ;
    private $op ;
    private $id ;
	
	public function __construct($pusr,$ppwd,$pce,$palm,$pop,$pid) {
		$this->usr = $pusr;
		$this->pwd = $ppwd;
		$this->ce = $pce;
		$this->alm = $palm;
		$this->op = $pop;
		$this->id = $pid;
	}
	

	public function obtUsr(){
		//Aqui se va a meter todo lo referente a la información
		echo 'usr: '.$this->usr.'     <br>';
		echo 'pwd: '.$this->pwd.'     <br>';
		echo 'ce: '.$this->ce.'     <br>';
		echo 'alm: '.$this->alm.'     <br>';
		echo 'op: '.$this->op.'     <br>';
		echo 'id: '.$this->id.'     <br>';
		echo 'Una vez que se reciben los prametros se puede mostrar cualquier información :D <br>';
		echo '{"login":"S","indmat":"N","asistencias":[{"Id":"200","Asist":"I","Fecha":"01/10/2014"},{"Id":"201","Asist":"R","Fecha":"02/10/2014"}]}';
	}
	
	public function getusr(){
		return $this->usr;
	}
	public function getpwd(){
		return $this->pwd;
	}
	public function getce(){
		return $this->ce;
	}
	public function getalm(){
		return $this->alm;
	}
	public function getop(){
		return $this->op;
	}
	public function getid(){
		return $this->id;
	}

}
		
?>