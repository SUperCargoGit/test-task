<?php

class Log {

	var $path = "";
	var $fileName = "LogFile.log";

	var $host = 'localhost';
	var $database = 'log';
	var $user = 'root';
	var $password = '';

	function logAddFile($entry){

		if ( ($this->path != "") && (substr($this->path, -1) != "/" && substr($this->path, -1) != "\\") ) $this->path = $this->path."/";
		$entry = date("Y-m-d H:i:s ").serialize($entry)."\r\n";

		$file = fopen($this->path.$this->fileName, "a");
		fwrite($file, $entry);
		fclose($file);
	}

	function logAddDB($entry){

		$entry = date("Y-m-d H:i:s ").serialize($entry);

		$link = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		$link->set_charset("utf8");
		$query = "insert into log (log) values('".$entry."')";
		mysqli_query($link, $query);
	}

	function logAddSTDOUT($entry) {
		$stdout = fopen('php://stdout','w');
		fwrite($stdout, $entry);
	}
}

?>