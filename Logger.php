<?php

abstract class Logger {

	protected function getText($entry) {
		return (gettype($entry) == "string") ? date("Y-m-d H:i:s ").$entry : date("Y-m-d H:i:s ").serialize($entry);
	}

	static function getInstance($type, $params = NULL){
		switch ($type) {
			case "stdout" : {
				return new STDLogger();
			}
			case "file" : {
				return new FileLogger($params[0]);
			}
			case "mysql" : {
				return new DBLogger($params[0],$params[1],$params[2],$params[3]);
			}
		}
	}

	abstract protected function logAdd($entry);

}

class STDLogger extends Logger{

	function logAdd($entry){
		echo $this->getText($entry);
	}
}

class FileLogger extends Logger{

	private $file;

	function __construct($file) { 
		$this->file = fopen($file, "a");
    }

    function __destruct() {
    	fclose($this->file);
    }

	public function logAdd($entry){
		fwrite($this->file, $this->getText($entry)."\r\n");
	}
}

class DBLogger extends Logger{

	private $DBH;

	function __construct($host,$dbname,$user,$pass) {
		try {   
			$this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
	}

	function __destruct() {
    	$this->DBH = NULL;
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

?>