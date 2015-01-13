<?php

$ROOT = "/nfs/raven/u1/r/rymalc/public_html/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/";

require_once $ROOT . "initialize.php";

$tables = query($mysql_handle,"SHOW TABLES");

for ($i = 0 ; $i < count($tables) ; ++$i)
{
	if (!(strcmp(substr($tables[$i][0],0,4),'view') == 0))
	{
		temp_out($mysql_handle,$tables[$i][0]);
	}
}

?>