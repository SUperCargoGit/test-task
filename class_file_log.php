<?php

class LogFile {

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
		$entry = date("Y-m-d H:i:s ").serialize($entry)."\r\n";
		$file = fopen($this->file, "a");
		fwrite($file, $entry);
		fclose($file);
	}
}

?>