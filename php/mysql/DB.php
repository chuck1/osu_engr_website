<?php

class DB {
	public $table_user = 'users';
	public $mysqli = 0;
	public $nickname = '';
	
	// method declaration
	public function __construct($nickname, $host, $name, $user, $pass)
	{
		$this->nickname = $nickname;
		$this->host = $host;
		$this->name = $name;
		$this->user = $user;
		$this->pass = $pass;
	}
	public function __destruct()
	{
		$this->mysqli->close();
	}
	public function connect()
	{
		$this->mysqli = new mysqli($this->host, $this->user, $this->pass);

		if ($this->mysqli->connect_errno)
		{
			printf("Connect failed: %s\n", $this->mysqli->connect_error);
			exit();
		}
		/*
		   if ($result = $this->mysqli->query("SELECT DATABASE()")) {
		   $row = $result->fetch_row();
		//printf("Default database is %s.\n", $row[0]);
		$result->close();
		}
		 */
		$this->mysqli->select_db($this->name);

		$this->query_b("USE `{$this->name}`");
	}
	public function get_post($var)
	{
		return $this->mysqli->real_escape_string($_POST[$var]);
	}
	public function query_b($query)
	{
		if (!$this->mysqli->query($query))
		{
			echo "Database access failed:" . $this->mysqli->error . " (" . $this->mysqli->errno . ")</br>Query: " . $query . "</br>";
		}
	}
	public function query($query)
	{
		$result = $this->mysqli->query($query);
		$results = array();
		if (!$result) die ( "Database access failed: " . $this->mysqli->error );
		$rows = mysqli_num_rows($result);
		for ($j = 0 ; $j < $rows ; ++$j) {
			$results[$j] = mysqli_fetch_array($result);
		}
		return $results;
	}
	public function temp_out($table)
	{
		$ROOT = $_SESSION['ROOT'];

		$result = query_b("
				SELECT * FROM {$table}
				INTO OUTFILE '{$ROOT}data/{$table}.csv'
				FIELDS TERMINATED BY ','
				");
	}
	public function entities_fix_string($string)
	{
		return htmlentities(mysql_fix_string($mysqli,$string));
	}
	public function fix_string($string)
	{
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $this->mysqli->real_escape_string($string);
	}
	public function add_user($un,$pw)
	{
		$query = "INSERT INTO users VALUES('$un', '$pw')";
		$result = query_b($query);
	}
	public function get_id_from_name($mysqli,$table,$name)
	{
		$result = query("SELECT * FROM {$table} WHERE name = {$name}");

		if (count($result)==1)
		{
			return $result[0]['id'];
		}
		else
		{
			return -1;
		}
	}
	public function authenticate()
	{
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
			$un_temp = $this->entities_fix_string($_SERVER['PHP_AUTH_USER']);
			$pw_temp = $this->entities_fix_string($_SERVER['PHP_AUTH_PW']);

			$result = $this->mysqli->query("SELECT * FROM `{$table_user}` WHERE username='$un_temp'");

			if (count($result)>0) {
				$row = $result[0];
				$salt1 = "qm&h*";
				$salt2 = "pg!@";
				$token = md5("$salt1$pw_temp$salt2");

				if ($token == $row['password']) {
					session_start();
					$_SESSION['username'] = $un_temp;
					$_SESSION['password'] = $pw_temp;
					echo "you are logged in as ".$row['username']."</br>";
				}
				else {
					header('WWW-Authenticate: Basic realm="Restricted Section"');
					header('HTTP/1.0 401 Unauthorized');
					die ("Please enter your username and password");
				}
			}
			else {
				header('WWW-Authenticate: Basic realm="Restricted Section"');
				header('HTTP/1.0 401 Unauthorized');
				die ("Please enter your username and password");
			}
		}
		else {
			header('WWW-Authenticate: Basic realm="Restricted Section"');
			header('HTTP/1.0 401 Unauthorized');
			die ("Please enter your username and password");
		}
	}
	public function create_table_sort($table_name) {
		$table_name = $this->nickname . "_" . $table_name;
		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->name}`.`{$table_name}_sort`
			(
			 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			 `col` VARCHAR(128) NOT NULL,
			 `dir` VARCHAR(4) NOT NULL
			)
			ENGINE = InnoDB;
		";

		$this->query_b($query);
	}
	public function create_table_tag($table_name) {
		$table_name = $this->nickname . "_" . $table_name;
		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->name}`.`{$table_name}_tag`
			(
			 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			 `name` VARCHAR(128) NOT NULL,
			 `selected` BOOL NOT NULL DEFAULT 0
			)
			ENGINE = InnoDB;
		";

		$this->query_b($query);
	}
	public function create_table_rel($table_name0,$table_name1) {
		$table_name  = $this->nickname . "_" . $table_name0 . "_" . $table_name1 . "_rel";
		$table_name0 = $this->nickname . "_" . $table_name0;
		$table_name1 = $this->nickname . "_" . $table_name1;
		$id0 = "{$table_name0}_id";
		$id1 = "{$table_name1}_id";

		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->name}`.`{$table_name}`
			(
			 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			 `{$id0}` INT NOT NULL,
			 `{$id1}` INT NOT NULL,
			 FOREIGN KEY (`{$id0}`) REFERENCES `{$table_name0}` (id),
			 FOREIGN KEY (`{$id1}`) REFERENCES `{$table_name1}` (id)
			)
			ENGINE = InnoDB;
		";

		$this->query_b($query);
	}
}



?>
