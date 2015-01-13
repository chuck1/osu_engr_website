<?php //setupusers.php

$query = "DROP TABLE IF EXISTS users";

query_b($mysql_handle,$query);

$query = "CREATE TABLE IF NOT EXISTS users (
			username VARCHAR(32) NOT NULL UNIQUE,
			password VARCHAR(32) NOT NULL
		)";

query_b($mysql_handle,$query);

$salt1 = "qm&h*";
$salt2 = "pg!@";

$username = 'rymalc';
$password = '';
$token    = md5("$salt1$password$salt2");
add_user($mysql_handle,$username,$token);

?>
