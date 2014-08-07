<?php

ini_set('display_errors',1);
error_reporting(~0);

$title = 'pub author rel';
$name = 'db0_lit';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . "init.php";

$c0 = new COMBO('pub_id',$db,	'pub',		array('id','title'));
$c1 = new COMBO('author_id',$db,'author',	array('id','forename','surname'));

$tb = new TABLE(0,$db,'pub_author_rel',array('id','pub_id','author_id'));
$fm = new FORM(	1,$db,'pub_author_rel',array($c0,$c1));
$tb->del = TRUE;


$fm->post();
$tb->post();


$main = $fm->disp();
$main .= $tb->disp();

require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';

?>


