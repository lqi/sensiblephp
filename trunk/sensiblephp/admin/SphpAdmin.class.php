<?php
class SphpAdmin
{
	function subcommandList() {
		return array(
			"help",
			"clean_project",
			"init_project",
			"create_app",
			"settings_wizard"
		);
	}
	
	function legalSubcommand($args) {
		foreach($this->subcommandList() as $subcommand) {
			if ($args == $subcommand)
				return true;
		}
		return false;
	}
	
	function execute($args, $option = null) {
		if ($this->legalSubcommand($args)) {
			if ($option == null) {
				$this->$args();
			}
			else {
				$this->$args($option);
			}
		}
		else {
			echo "Unknown command: '" . $args . "'\n";
			$this->helpGuide();
		}		
	}
	
	function welcome() {
		echo "Sensible PHP Admin\n";
	}
	
	function helpGuide() {
		echo "Type 'sphpadmin.php help' for usage.\n";
	}
	
	function help($option = null) {
		if ($option == null) {
			$this->helphelp();
		}
		else {
			if ($this->legalSubcommand($option)) {
				$helpMethod = "help" . $option;
				$this->$helpMethod();
			}
			else {
				echo "Unknown subcommand: '" . $option . "'\n";
				$this->helpGuide();
			}
		}
	}
	
	function helphelp() {
		echo "usage: sphpadmin.php <subcommand> [args]\n\n";

		echo "Available subcommands:\n";
		foreach($this->subcommandList() as $subcommand) {
			echo "    " . $subcommand . "\n";
		}
	}
	
	function helpclean_project() {
		echo "usage: sphpadmin.php clean_project\n";
		echo "PAY ATTENTION: all user files in this project will be deleted.\n";
	}

	function helpinit_project() {
		echo "usage: sphpadmin.php init_project\n";
		echo "Initialize the project. \n";
		echo "PAY ATTENTION: all EXISTING user files in this project will be deleted.\n";
	}
	
	function helpcreate_app() {
		echo "usage: sphpadmin.php create_app app_name\n";
		echo "Create a new web application, will automatically generate the related files for user to modify.\n";
	}
	
	function helpsettings_wizard() {
		echo "usage: sphpadmin.php settings_wizard\n";
		echo "A command line based settings wizard will help user configurating the settings.\n";
	}
}
