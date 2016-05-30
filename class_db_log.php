<?php

class LogDB {

	private $host = 'localhost';
	private $database = 'log';
	private $user = 'root';
	private $password = '';

	function __construct() { 
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }

    private function __construct4($host,$database,$user,$password) {
    	$this->host = $host;
    	$this->database = $database;
    	$this->user = $user;
    	$this->password = $password;
    }


	public function logAdd($entry){

		$entry = date("Y-m-d H:i:s ").serialize($entry);

		$mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);
		if ($mysqli->connect_error) {
    		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}

		$mysqli->set_charset("utf8");
		$mysqli->query("insert into log (log) values('$entry')");
		if ($mysqli->errno) {
			die('INSERT Error (' . $mysqli->errno . ') ' . $mysqli->error);
		}

		$mysqli->close();
	}
}

?>