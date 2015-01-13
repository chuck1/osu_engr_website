<?php

ini_set('display_errors',1);
error_reporting(~0);

$title = 'publications';
$name = 'db0_lit';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . "init.php";





$tb = new TABLE(0,$db,'pub',array('id','title'));
$fm = new FORM(	1,$db,'pub',array('title'));

$tb->del = FALSE;
$tb->up  = TRUE;
$tb->filter = FALSE;

//$tb->searchby = 'title';

$fm->post();
$tb->post();



$main = $fm->disp();
$main .= $tb->disp();


require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';

 
?>
