<?php

abstract class Logger {

	protected function getText($entry) {
		return date("Y-m-d H:i:s ").serialize($entry);
	}

	abstract protected function logAdd($entry);

}

class DBLogger extends Logger{

	private $DBH;

	function __construct() { 
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }

	private function __construct0() {
		try {
			$this->DBH = new PDO("mysql:host=localhost;dbname=log", 'root', ''); 
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
	}

	private function __construct4($host,$dbname,$user,$pass) {
		try {   
			$this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
	}

	function logAdd($entry) {
		try {
			$STH = $this->DBH->prepare("INSERT INTO log (log) values (?)");
			$STH->bindParam(1, $this->getText($entry));
  			$STH->execute();
		}
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
	}
}

class FileLogger extends Logger{

	private $file = "LogFile.log";

	function __construct() { 
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }

    function __construct1($file) {
    	$this->file = $file;
    }

	public function logAdd($entry){
		$file = fopen($this->file, "a");
		fwrite($file, $this->getText($entry)."\r\n");
		fclose($file);
	}
}

class STDLogger extends Logger{

	public function logAdd($entry){
		$stdout = fopen('php://stdout','w');
        fwrite($stdout, $this->getText($entry));
	}
}

?>