<?php

ini_set('display_errors',1);
error_reporting(~0);

$root = dirname(__FILE__);

require_once  $root."/private/db_info.php";

//$http_root = 'http://web.engr.oregonstate.edu/~rymalc/';
$http_home = $http_root . $name . '/';

require_once $root."/php/myphp.php";

function insert_tab($n,$html)
{
	for ( $a = 0; $a < $n; $a++ )
	{
		$html .= "\t";
	}
}
function process_folder($xmlobj,$d,$pcum,$html)
{
	$t = $xmlobj->attributes()->title;
	$pcum .= $xmlobj->attributes()->url;
	$p = $pcum . "index.html";
	
	$indent = 30 * $d;
	
	insert_tab( 2 );
	$html .= "<span style=\"padding-left:{$indent}px\" ";
	$html .= "class=\"link\" ";
	$html .= "onclick=\"h1('{$p}','{$t}')\" ";
	$html .= "onmouseover=\"linkhl(this)\" ";
	$html .= "onmouseout=\"linkunhl(this)\" ";
	$html .= ">{$t}</span><br>\n";
	
	for ( $a = 0; $a < count($xmlobj->page); $a++ )
	{
		process_page($xmlobj->page[$a],$d+1,$pcum,$html);
	}
	
	for ( $a = 0; $a < count($xmlobj->folder); $a++ )
	{
		process_folder($xmlobj->folder[$a],$d+1,$pcum,$html);
	}

	return $html;
}
function process_page($xmlobj,$d,$pcum,$html)
{
	$t = $xmlobj->attributes()->title;
	$pcum .= $xmlobj->attributes()->url;
	$p = $pcum . ".html";
	
	$indent = 30 * $d;
	
	insert_tab( 2 );
	$html .= "<span style=\"padding-left:{$indent}px\" ";
	$html .= "class=\"link\" ";
	$html .= "onclick=\"h1('{$p}','{$t}')\" ";
	$html .= "onmouseover=\"linkhl(this)\" ";
	$html .= "onmouseout=\"linkunhl(this)\" ";
	$html .= ">{$t}</span><br>\n";
	
	return $html;
}

?>


