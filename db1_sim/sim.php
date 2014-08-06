<?php

ini_set('display_errors',1);
error_reporting(~0);

$name = 'db1_sim';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . 'init.php';

$tb = new TABLE(0,$db,'sim',array('id','desc'));
$tb->del = FALSE;
$tb->up  = TRUE;

$tb->searchby = 'desc';

$tb->post();

$main = $tb->disp();


require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';

?>
