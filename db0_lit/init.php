<?php

require_once(dirname(dirname(__FILE__)) . "/init.php");

$db = new DB('db0', $db_host, $db_name, $db_user, $db_pass);
$db->connect();

$db->create_table_sort(	'pub');
$db->create_table_sort(	'author');
$db->create_table_tag(	'pub');
$db->create_table_sort(	'pub_tag');
$db->create_table_rel(	'pub','pub_tag');
$db->create_table_sort(	'pub_pub_tag_rel');
$db->create_table_rel(	'pub','author');
$db->create_table_sort(	'pub_author_rel');

?>


