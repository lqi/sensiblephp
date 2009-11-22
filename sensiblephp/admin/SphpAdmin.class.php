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
	
	function userFolders() {
		return array(
			"controllers",
			"db",
			"models",
			"views"
		);
	}
	
	function legalSubcommand($args) {
		foreach($this->subcommandList() as $subcommand) {
			if ($args == $subcommand)
				return true;
		}
		return false;
	}
	
	function projectRoot() {
		return getcwd() . "/";
	}
	
	function trashPath() {
		return $this->projectRoot() . ".Trash/";
	}

	function moveToFolder($oldPath, $newPath) {
		if(file_exists($oldPath)) {
			exec("mv " . $oldPath . " " . $newPath);
		}
		else {
			throw new Exception("Exception: Old path doesn't exist!");
		}
	}

	function recreateFolder($path) {
		if(file_exists($path)) {
			exec("rm -rf " . $path);
		}
		exec("mkdir " . $path);
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
	
	function moveToTrash($oldFolder) {
		$oldPath = $this->projectRoot() . $oldFolder;
		$this->moveToFolder($oldPath, $this->trashPath());
	}
	
	function recreateTrash() {
		$this->recreateFolder($this->trashPath());
	}
	
	function clean_project() {
		$this->recreateTrash();
		
		foreach($this->userFolders() as $folder) {
			$this->moveToTrash($folder);
		}
	}
	
	function init_project() {
		$this->clean_project();
		
		foreach($this->userFolders() as $folder) {
			$folderPath = $this->projectRoot() . $folder;
			$this->recreateFolder($folderPath);
		}
	}
	
	private function touchModelClass($appName) {
		$file = fopen($this->projectRoot() . "models/" . $appName . ".class.php", 'w');
		$content = "<?php\nclass " . $appName . " extends Model {\n" .
						"\tprotected \$id;\t\t//You can modify, delete this attribute, and add more.\n" .
						"\n" .
						"\tpublic function __construct() {\n" .
						"\t\t\$this->id = new IntegerField;\t\t//Modify, delete and add.\n" .
						"\n" .
						"\t\t\$this->setPKField(\"id\");\t\t//Set the primary key here.\n" .
						"\t}\n" .
						"}\n" .
						"?>";
		fwrite($file, $content);
		fclose($file);
	}
	
	private function touchControllerClass($appName) {
		$file = fopen($this->projectRoot() . "controllers/" . $appName . "Controller.class.php", 'w');
		$content = "<?php\nclass " . $appName . "Controller extends Controller {\n" .
					"}\n" .
					"?>";
		fwrite($file, $content);
		fclose($file);
	}
	
	private function touchDbClass($appName) {
		$file = fopen($this->projectRoot() . "db/" . $appName . "Db.class.php", 'w');
		$content = "<?php\nclass " . $appName . "Db extends Database {\n" .
					"}\n" .
					"?>";
		fwrite($file, $content);
		fclose($file);
	}
	
	function create_app($appName = null) {
		if($appName == null) {
			echo "No app name given. Type 'sphpadmin.php help create_app' for help.\n";
		}
		else {
			if(file_exists($this->projectRoot() . "models/" . $appName . ".class.php")) {
				echo "App '" . $appName . "' already exists.\n";
			}
			else {
				$this->touchModelClass($appName);
				$this->touchDbClass($appName);
				$this->touchControllerClass($appName);
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
		echo "Don't be afraid, actually, they are moved to the '.Trash' folder in this project's root folder. But those previous removed version existing in Trash will be deleted forever. TAKE CARE!\n";
	}

	function helpinit_project() {
		echo "usage: sphpadmin.php init_project\n";
		echo "Initialize the project. \n";
		echo "PAY ATTENTION: all EXISTING user files in this project will be deleted. Type 'sphpadmin.php help clean_project' for details.\n";
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
