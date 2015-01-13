<?php

$ROOT = "/nfs/raven/u1/r/rymalc/public_html/tm/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/tm/";


require_once $ROOT . "../initialize.php";

if (isset($_POST['search']))
{
	$search = get_post($mysql_handle,'search');
	
	$query = <<<_END
	SELECT
	`tm_task`.`short_desc`,
	`tm_task`.`timestamp_created`,
	`tm_task`.`timestamp_start`,
	`tm_task`.`timestamp_end`,
	`tm_task`.`priority`,
	`tm_status`.`name` AS `status_name`
	FROM
	`tm_task`,
	`tm_status`
	WHERE
	`tm_task`.`short_desc` LIKE '%{$search}%'
	AND
	`tm_task`.`status_id` = `tm_status`.`id`
	ORDER BY `timestamp_end` ASC, `priority` ASC
_END;
	
}
else
{
	$query = <<<_END
	SELECT
	`tm_task`.`id`,
	`tm_task`.`short_desc`,
	`tm_task`.`timestamp_created`,
	`tm_task`.`timestamp_start`,
	`tm_task`.`timestamp_end`,
	`tm_task`.`priority`,
	`tm_status`.`name` AS `status_name`
	FROM
	`tm_task`,
	`tm_status`
	WHERE
	`tm_task`.`status_id` = `tm_status`.`id`
	ORDER BY `timestamp_end` ASC, `priority` ASC
_END;
}

if (isset($_POST['delete_id']))
{
	$delete_id = get_post($mysql_handle,'delete_id');
	
	query_b($mysql_handle,"DELETE FROM tm_task_tag WHERE task_id = $delete_id");
	
	query_b($mysql_handle,"DELETE FROM tm_task WHERE id = $delete_id");
}

//--------------------------------------------------

$results = query($mysql_handle,$query);

$rows = "";
for ($row=0;$row<count($results);$row++)
{
	$tag_result = query($mysql_handle,"
	SELECT `tm_tag`.`name` FROM tm_task_tag,tm_tag
	WHERE `tm_task_tag`.`task_id` = {$results[$row]['id']}
	AND `tm_task_tag`.`tag_id` = `tm_tag`.`id`
	");
	
	$tag_rows = "";
	
	for ($tag_row=0;$tag_row<count($tag_result);$tag_row++)
	{
		$tag_rows .= <<<_END
				<tr>
					<td>
						{$tag_result[$tag_row]['name']}
					</td>
				</tr>
_END;
	}
	
	$rows .= <<<_END
	<tr>
		<td>{$results[$row]['short_desc']}</td>
		<td>{$results[$row]['status_name']}</td>
		<td>{$results[$row]['priority']}</td>
		<td>{$results[$row]['timestamp_created']}</td>
		<td>{$results[$row]['timestamp_start']}</td>
		<td>{$results[$row]['timestamp_end']}</td>
		<td>
			<table>
				{$tag_rows}
			</table>
		</td>
		<form action='{$HTTP_ROOT}index.php' method='post'>
			<input type='hidden' name='delete_id' value={$results[$row]['id']}>
			<td>
				<input type='submit' value='delete'>
			</td>
		</form>
		
	</tr>
_END;
}

//--------------------------------------------------

echo <<<_END
<p>
	<table border="1">
		<form action='{$HTTP_ROOT}create_task.php' method='post'>
			<td>
				<input type='submit' value='create task'>
			</td>
		</form>
		<form action='{$HTTP_ROOT}create_tag.php' method='post'>
			<td>
				<input type='submit' value='create tag'>
			</td>
		</form>
	</table>
</p>


<p><table border="1"><form action='{$HTTP_ROOT}index.php' method='post'>
	<tr>
		<td>search short desc</td>
		<td><input style="width:600px" type='text' name='search'></td>
	</tr>
	<tr>
		<td><input type='submit' value='search'></td>
	</tr>
</form></table></p>

<p><table border="1">
	{$rows}
</table></p>

_END;

mysqli_close($mysql_handle);

?>