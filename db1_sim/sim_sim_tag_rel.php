<?php

$ROOT  = "/nfs/raven/u1/r/rymalc/simlic_html/";
$ROOT2 = "db1_sim/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/";

require_once $ROOT . $ROOT2 . "init.php";

$c0 = new COMBO('sim_id',		$db,	'sim',		array('id','title'));
$c1 = new COMBO('sim_tag_id',	$db,	'sim_tag',	array('id','name'));

$tb = new TABLE(0,$db,'sim_sim_tag_rel',array('id','sim_id','pag_tag_id'));
$fm = new FORM(	1,$db,'sim_sim_tag_rel',array($c0,$c1));
$tb->del = TRUE;

$fm->post();
$tb->post();

require_once $ROOT . $ROOT2 . "header.php";

$fm->disp();
$tb->disp();

require_once $ROOT . $ROOT2 . "footer.php";


?>