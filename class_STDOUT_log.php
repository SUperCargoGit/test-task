<?php

class LogSTDOUT {

	public function logAdd($entry){
        $entry = date("Y-m-d H:i:s ").serialize($entry);
		$stdout = fopen('php://stdout','w');
        fwrite($stdout, $entry);
	}
}

?>