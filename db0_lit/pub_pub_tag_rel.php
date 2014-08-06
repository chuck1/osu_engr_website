<?php

ini_set('display_errors',1);
error_reporting(~0);

$title = 'publications';
$name = 'db0_lit';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . "init.php";

$c0 = new COMBO('pub_id',	$db,	'pub',		array('id','title'));
$c1 = new COMBO('pub_tag_id',	$db,	'pub_tag',	array('id','name'));

$tb = new TABLE(0,$db,'pub_pub_tag_rel',array('id','pub_id','pub_tag_id'));
$fm = new FORM(	1,$db,'pub_pub_tag_rel',array($c0,$c1));
$tb->del = TRUE;

$fm->post();
$tb->post();


$main = $fm->disp() . $tb->disp();


require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';


?>
