<?php

ini_set('display_errors',1);
error_reporting(~0);

$title = 'authors';
$name = 'db0_lit';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . "init.php";




$tb = new TABLE(0,$db,'author',array('id','forename','surname'));
$fm = new FORM(	1,$db,'author',array('forename','surname'));

$tb->del = TRUE;
$tb->up  = TRUE;
$tb->searchby = 'surname';

$fm->post();
$tb->post();


$main = $fm->disp();
$main .= $tb->disp();

require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';

?>
