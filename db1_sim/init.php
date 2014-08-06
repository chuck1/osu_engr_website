<?php

require_once $root . "init.php";

$db = new DB('db1');
$db->connect();


$query = <<<_END
CREATE TABLE IF NOT EXISTS `rymalc-db`.`db1_sim`
(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`desc` varchar(1000)
)
ENGINE = InnoDB;
_END;

$db->query_b($query);

$db->create_table_sort('sim');

$db->create_table_tag('sim');
$db->create_table_sort('sim_tag');

$db->create_table_rel('sim','sim_tag');
$db->create_table_sort('sim_sim_tag_rel');


?>