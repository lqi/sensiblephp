#!/usr/bin/env php
<?php
	require(getcwd() . "/sensiblephp/init.php");
	$spAdmin = new SphpAdmin;
	
	$spAdmin->welcome();
	
	if (!empty($argc) && $argc > 1) {
		if ($argc == 2) {
			$spAdmin->execute($argv[1]);
		}
		else {
			$spAdmin->execute($argv[1], $argv[2]);
		}
	}
	else {
		$spAdmin->helpGuide();
	}

?>