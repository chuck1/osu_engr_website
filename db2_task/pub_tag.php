<?php

$ROOT  = "/nfs/raven/u1/r/rymalc/public_html/";
$ROOT2 = "db0_lit/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/";

require_once $ROOT . $ROOT2 . "init.php";

$tb = new TABLE(0,$db,'pub_tag',array('id','name','selected'));
$fm = new FORM(	1,$db,'pub_tag',array('name'));
$tb->del = TRUE;
$tb->up  = TRUE;
$tb->searchby = 'name';

$fm->post();
$tb->post();

require_once $ROOT . $ROOT2 . "header.php";

$fm->disp();
$tb->disp();

require_once $ROOT . $ROOT2 . "footer.php";

?>