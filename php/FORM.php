<?php

class FORM
{
	public $id;
	public $table;
	public $action = '';
	public $db;
	public $col;
	
	public $rows;
	
	public function __construct($id,$db,$table,$col) {
		$this->db=$db;
		$this->action='';//$action;
		$this->table= $this->db->nickname . "_" . $table;
		$this->col=$col;
	}
	public function insert($val) {
		if ( is_array($this->col) ) {
			$this->insert_array($val);
		}
		else {
			die("col must be array");
		}
		
	}
	public function post() {
		if ( isset($_POST["insert{$this->id}"]) )
		{
			//echo "insert...</br>";
			if ( is_array($this->col) )
			{
				$this->post_array();
			}
			else
			{
				die("col must be array");
			}
		}
	}
	public function post_array() {
		$val = array();
		$all_posted = TRUE;
		
		foreach ( $this->col as $c )
		{
			if ( is_string($c) )
			{
				if ( !isset($_POST[$c]) )
				{
					$all_posted = FALSE;
					echo $c . " not posted</br>";
				}
			}
			elseif ( strcmp(get_class($c),'COMBO')==0 ) {
				if ( !isset($_POST[$c->name]) )
				{
					$all_posted = FALSE;
					echo $c->name . " not posted</br>";
				}
			}
			else
			{
				die("c must be string or COMBO");
			}
		}
		
		if ( $all_posted )
		{
			foreach ( $this->col as $c )
			{
				if ( is_string($c) ) {
					$val[] = $this->db->get_post($c);
					
				}
				elseif ( strcmp(get_class($c),'COMBO')==0 ) {
					$val[] = $this->db->get_post($c->name);
					
				}
			}
			//print_r($val);
			//echo "</br>";
			$this->insert($val);
		}
	}
	public function insert_array($val) {
		$colstr = "";
		$valstr = "";
		
		
		for ( $i = 0; $i < count($this->col); ++$i )
		{
			$c = $this->col[$i];
			
			if ( $i > 0 )
			{
				$colstr .= ",";
				$valstr .= ",";
			}
			
			if ( is_string($c) ) {
				$colstr .= $c;
			}
			elseif ( strcmp(get_class($c),'COMBO')==0 ) {
				$colstr .= $c->name;
			}
			
			$valstr .= "'" . $val[$i] . "'";
			
			
		}
		
		
		$this->db->query_b("
			INSERT INTO {$this->table}
			({$colstr})
			VALUES({$valstr})");
	}
	public function disp_combo($c) {
		$this->rows .= <<<_END
			<tr>
				<td>{$c->name}</td>
				<td>{$c->disp()}</td>
			</tr>

_END;
	}
	public function disp_string($c) {
		$name = $c;
					
		$this->rows .= <<<_END
			<tr>
				<td>{$name}</td>
				<td><input class="long" type='text' name='{$name}'></td>
			</tr>

_END;

	}
	public function disp() {
		$this->rows = "";
		
		if ( is_array($this->col) ) {
			foreach ( $this->col as $c ) {
				if ( is_string($c) ) {
					$this->disp_string($c);
				}
				elseif ( strcmp(get_class($c),'COMBO')==0 ) {
					$this->disp_combo($c);
				}
				else {
					die("bad col type");
				}
			}
		}
		else {
			die("col must be array");
		}
		
		$this->html =  <<<_END
	
<p>
	<table>
		<form action='{$this->action}' method='post'>
{$this->rows}
			<tr>
				<input type='hidden' name='insert' value='1'></input>
				<td><input type='submit' value='submit'></td>
			</tr>
		</form>
	</table>
</p>
_END;
	
		return $this->html;
	}
}



?>
