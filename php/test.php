<?php

require_once "mysql/DB.php";
require_once "TABLE.php";
require_once "FORM.php";

$db = new DB();

$db->connect();

$fm = new FORM(		$db,'',	'wd_guest',array('name','rsvp'));
$tb = new TABLE(	$db,	'wd_guest',array('name','rsvp'));
$tb->del = TRUE;
$tb->up  = TRUE;

$fm->post();
$tb->post();

$fm->disp();
$tb->disp();

?>