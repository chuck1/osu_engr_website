<?php

$name = 'db1_sim';
$root = '/nfs/raven/u1/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . 'init.php';


$tb = new TABLE(0,$db,'sim',array('id','desc'));
$fm = new FORM(1,$db,'sim',array('desc'));
$tb->del = FALSE;
$tb->up  = TRUE;

$fm->post();
$tb->post();



$main = $fm->disp();
$main .= $tb->disp();


require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';
 
?>