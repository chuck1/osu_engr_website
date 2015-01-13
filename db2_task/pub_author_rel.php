<?php

$ROOT  = "/nfs/raven/u1/r/rymalc/public_html/";
$ROOT2 = "db0_lit/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/";

require_once $ROOT . $ROOT2 . "init.php";

$c0 = new COMBO('pub_id',$db,	'pub',		array('id','title'));
$c1 = new COMBO('author_id',$db,'author',	array('id','forename','surname'));

$tb = new TABLE(0,$db,'pub_author_rel',array('id','pub_id','author_id'));
$fm = new FORM(	1,$db,'pub_author_rel',array($c0,$c1));
$tb->del = TRUE;


$fm->post();
$tb->post();

require_once $ROOT . $ROOT2 . "header.php";

$fm->disp();
$tb->disp();

require_once $ROOT . $ROOT2 . "footer.php";


?>