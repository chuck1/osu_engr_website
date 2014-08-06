<?php

$ROOT = "/nfs/raven/u1/r/rymalc/public_html/tm/";
$HTTP_ROOT = "http://people.oregonstate.edu/~rymalc/tm/";

require_once $ROOT . "../initialize.php";

$action = "create_task";

//--------------------------------------------------

$tag_results = query($mysql_handle,"SELECT * FROM `tm_tag`");

//--------------------------------------------------

if (isset($_POST['short_desc']))
{
	$short_desc = get_post($mysql_handle,'short_desc');
	
	$created_date = get_post($mysql_handle,'created_date');
	$start_date = get_post($mysql_handle,'start_date');
	$end_date = get_post($mysql_handle,'end_date');
	$created_time = get_post($mysql_handle,'created_time');
	$start_time = get_post($mysql_handle,'start_time');
	$end_time = get_post($mysql_handle,'end_time');
	
	$priority = get_post($mysql_handle,'priority');
	
	//$tag = get_post($mysql_handle,'tag');
	
	$tag = $_POST['tag'];
	echo "</br>";
	
	print_r($tag);
	
	query_b($mysql_handle,"
		INSERT INTO tm_task
		(
		short_desc,
		timestamp_created,
		timestamp_start,
		timestamp_end,
		status_id,
		priority
		)
		VALUES
		(
		'{$short_desc}',
		'{$created_date} {$created_time}:00',
		'{$start_date} {$start_time}:00',
		'{$end_date} {$end_time}:00',
		1,
		{$priority}
		)
		");
	
	
	$insert_task_id = $mysql_handle->insert_id;
	
	for ($row=0;$row<count($tag_results);$row++)
	{
		if ( isset( $tag[$tag_results[$row]['id']] ) )
		{
			echo $tag_results[$row]['id'] . " " . $tag_results[$row]['name'] . "</br>";
			
			query_b($mysql_handle,"
			INSERT INTO tm_task_tag
			(
			task_id,
			tag_id
			)
			VALUES
			(
			{$insert_task_id},
			{$tag_results[$row]['id']}
			)
			");
		}
	}
}

//--------------------------------------------------

$date = date('Y-m-d');

$date_today = date_create();
$date_tomorrow = date_create();
$date_tomorrow->modify('+1 day');

//--------------------------------------------------

$tag_rows = "";
for ($row=0;$row<count($tag_results);$row++)
{
	$tag_rows .= <<<_END
	<tr>
		<td>
			
		</td>
		<td>
			<input type='checkbox' name='tag[{$tag_results[$row]['id']}]' value="1"> {$tag_results[$row]['name']}
		</td>
	</tr>
_END;
}

//------------------------------------------------

echo <<<_END

<p>
	<table border="1">
		<form action='{$HTTP_ROOT}{$action}.php' method='post'>
			<tr>
				<td>
					short desc
				</td>
				<td>
					<input style="width:600px" type='text' name='short_desc'>
				</td>
			</tr>
			<tr>
				<td>
					created
				</td>
				<td>
					<input type="date" name="created_date" value="{$date_today->format('Y-m-d')}"><input type="time" name="created_time" value="{$date_today->format('H:i')}">
				</td>
			</tr>
			<tr>
				<td>
					start
				</td>
				<td>
					<input type="date" name="start_date" value="{$date_today->format('Y-m-d')}"><input type="time" name="start_time" value="{$date_today->format('H:i')}">
				</td>
			</tr>
			<tr>
				<td>
					end
				</td>
				<td>
					<input type="date" name="end_date" value="{$date_tomorrow->format('Y-m-d')}"><input type="time" name="end_time" value="{$date_today->format('H:i')}">
				</td>
			</tr>
			<tr>
				<td>
					priority (1=highest, 10=lowest)
				</td>
				<td>
					<input type="number" name="priority" min="1" max="10" value="1">
				</td>
			</tr>
			{$tag_rows}
			<tr>
				<td><input type='submit' value='create task'></td>
			</tr>
		</form>
	</table>
</p>


_END;

mysqli_close($mysql_handle);

?>