<?php

ini_set('display_errors',1);
error_reporting(~0);

$title = 'publications';
$name = 'db0_lit';
$root = '/nfs/stak/students/r/rymalc/public_html/';
$home = $root . $name . '/';

require_once $home . "init.php";


$query = "CREATE OR REPLACE VIEW a AS SELECT
db0_pub_pub_tag_rel.id,
db0_pub_pub_tag_rel.pub_id,
db0_pub_pub_tag_rel.pub_tag_id,
db0_pub.title AS pub_name,
db0_pub_tag.name AS tag_name
FROM db0_pub_pub_tag_rel,db0_pub,db0_pub_tag
WHERE
db0_pub_pub_tag_rel.pub_id = db0_pub.id
AND db0_pub_pub_tag_rel.pub_tag_id = db0_pub_tag.id;
";

$db->query_b($query);



$c0 = new COMBO('pub_id',	$db,	'pub',		array('id','title'));
$c1 = new COMBO('pub_tag_id',	$db,	'pub_tag',	array('id','name'));

/*$tb = new TABLE(
		0,
		$db,
		'pub_pub_tag_rel'
		array('id','pub_id','pub_tag_id'));
		);
*/

$tb = new VIEW(
		0,
		$db,
		'pub_pub_tag_rel',
		'a',
		array('id','pub_id','pub_name','pub_tag_id','tag_name')
		);


$tb->del = TRUE;


$fm = new FORM(	1,$db,'pub_pub_tag_rel',array($c0,$c1));


$fm->post();
$tb->post();


$main = $fm->disp() . $tb->disp();


require_once $root . 'head.php';
require_once $home . 'side.php';
require_once $root . 'page.php';


?>
