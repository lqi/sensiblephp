#!/usr/bin/env php
<?php
	require(getcwd() . "/sensiblephp/admin/SphpAdmin.class.php");
	$spAdmin = new SphpAdmin;
	
	$spAdmin->welcome();
	
	if (!empty($argc) && $argc > 1) {
		$spAdmin->execute($argv[1], $argv[2]);
	}
	else {
		$spAdmin->helpGuide();
	}

?>