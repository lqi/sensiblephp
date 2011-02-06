<?php
class SphpAdmin
{
	function subcommandList() {
		return array(
			"help",
			"clean_project",
			"init_project",
			"create_app",
			"settings_wizard",
			"dbsync_app"
		);
	}
	
	function userFolders() {
		return array(
			"controllers",
			"db",
			"models",
			"views",
			"test"
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
		return dirname(dirname(dirname(__file__))) . "/";
	}
	
	function trashPath() {
		return $this->projectRoot() . ".Trash/";
	}

	function moveToFolder($oldPath, $newPath) {
		if(file_exists($oldPath)) {
			exec("mv " . $oldPath . " " . $newPath);
		}
		/*
		else {
			throw new RuntimeException("Exception: Old path doesn't exist!");
		}
		*/
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
		
		$this->touchHomepageControllerClass();
		
		$this->settings_wizard();
	}
	
	private function touchHomepageControllerClass() {
		$file = fopen($this->projectRoot() . "controllers/HomepageController.class.php", 'w');
		$content = "<?php\nclass HomepageController extends Controller {\n" .
					"\tfunction indexAction() {\n" .
					"\t\techo \"<h1>It works!</h1><p> - Greetings from SensiblePHP framework!</p>\";\n" .
					"\t}\n" .
					"}\n" .
					"?>";
		fwrite($file, $content);
		fclose($file);
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
	
	function settings_wizard() {
		echo "Debug model, type 'true' or 'false', leave blank for 'false': ";
		$debugModel = substr(fgets(STDIN), 0, -1);
		if ($debugModel != "true") {
			$debugModel = "false";
		}
		echo "Time zone, read 'http://php.net/manual/en/timezones.php' for supported time zones, leave blank for 'America/Los_Angeles': ";
		$timezone = substr(fgets(STDIN), 0, -1);
		echo "Database host, leave blank for 'localhost': ";
		$host = substr(fgets(STDIN), 0, -1);
		echo "Database port: ";
		$port = substr(fgets(STDIN), 0, -1);
		echo "Database username: ";
		$user = substr(fgets(STDIN), 0, -1);
		echo "Database password: ";
		$pwd = substr(fgets(STDIN), 0, -1);
		echo "Database name: ";
		$dbname = substr(fgets(STDIN), 0, -1);
		$file = fopen($this->projectRoot() . "conf/Settings.class.php", 'w');
		$content = "<?php\nclass Settings {\n" .
					"\t/*\n" .
					"\t\tGeneral Settings\n" .
					"\t*/\n" .
					"\tprivate \$debug = " . $debugModel . ";\t\t//Debug model, choose true or false\n" .
					"\tprivate \$timezone = \"" . $timezone . "\";\t\t//Leave blank for \"America/Los_Angeles\"\n" .
					"\n" .
					"\t/*\n" .
					"\t\tDatabase Settings\n" .
					"\t*/\n" .
					"\tprivate \$host = \"" . $host . "\";\t\t//Host of Database, leave blank for \"localhost\"\n" .
					"\tprivate \$port = \"" . $port . "\";\t\t//Port of Database, leave blank for null\n" .
					"\tprivate \$user = \"" . $user . "\";\t\t//Username of Database, leave blank for null\n" .
					"\tprivate \$password = \"" . $pwd . "\";\t\t//Password of Database, leave blank for null\n" .
					"\tprivate \$dbname = \"" . $dbname . "\";\t\t//Database name, leave blank for null\n" .
					"\n" .
					"\t/*\n" .
					"\t\tDon't modify anything below\n" .
					"\t*/\n" .
					"\tpublic function __get(\$key) {\n" .
					"\t\treturn \$this->\$key;\n" .
					"\t}\n" .
					"}\n" .
					"?>";
		fwrite($file, $content);
		fclose($file);
		echo "Wizard has generated settings file in 'conf' folder.\n";
	}
	
	function dbsync_app($appName = null) {
		if($appName == null) {
			echo "No app name given. Type 'sphpadmin.php help dbsync_app' for help.\n";
		}
		else {
			if(file_exists($this->projectRoot() . "models/" . $appName . ".class.php")) {
				$dbClassName = $appName . "Db";
				$dbObject = new $dbClassName;
				if($dbObject->create()) {
					echo "Database for '" . $appName . "' sync is done.\n";
				}
			}
			else {
				echo "App '" . $appName . "' doesn't exist.\n";
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

	function helpdbsync_app() {
		echo "usage: sphpadmin.php dbsync_app app_name\n";
		echo "Database sync command.\n";
	}
}
