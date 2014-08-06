<?php

$ROOT = "/nfs/raven/u1/r/rymalc/public_html/tm2/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/tm2/";

require_once $ROOT . "../initialize.php";



if (isset($_POST['tag_id']))
{
	$tag_id = get_post($mysql_handle,'tag_id');
	
	query_b($mysql_handle,"DELETE FROM tm_tag WHERE id=$tag_id");
	
}

if (isset($_POST['name']))
{
	$name = get_post($mysql_handle,'name');
	
	query_b($mysql_handle,"
		INSERT INTO tm_tag
		(
		name
		)
		VALUES
		(
		'{$name}'
		)
		");
	
}

//--------------------------------------------------

$query = <<<_END
SELECT * FROM `tm_tag`
_END;

$results = query($mysql_handle,$query);

$rows = "";
for ($row=0;$row<count($results);$row++)
{
	$rows .= <<<_END
	<tr><form action='{$HTTP_ROOT}tm_tag.php' method='post'>
		<input type='hidden' name='tag_id' value={$results[$row]['id']}>
		<td>{$results[$row]['name']}</td>
		<td><input type='submit' value='delete'></td>
	</form></tr>
_END;
}

//--------------------------------------------------

echo <<<_END

<p><table border="1"><form action='{$HTTP_ROOT}create_tag.php' method='post'>
	<tr>
		<td>name</td>
		<td><input style="width:200px" type='text' name='name'></td>
	</tr>
	<tr>
		<td><input type='submit' value='create tag'></td>
	</tr>
</form></table></p>

<p><table border="1">
	{$rows}
</table></p>

_END;

mysqli_close($mysql_handle);

?>