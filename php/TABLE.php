<?php

class TABLE
{
	public $id;
	public $db;
	public $table;
	public $col;
	public $coltype;
	public $del = FALSE;
	public $up = FALSE;
	public $cols;
	public $rows;
	public $searchby  = '';
	public $description = array();
	public $filter = FALSE;
	public $html = '';
	
	public function __construct($id,$db,$table,$col) {
		$this->db = $db;
		$this->name = $table;
		$this->table = $this->db->nickname . "_" . $table;
		$this->col = $col;
		
		$results = $this->db->query("DESCRIBE {$this->table};");
		
		foreach ( $results as $row ) {
			$this->description[$row['Field']] = $row;
			$this->coltype[$row['Field']] = $row['Type'];
		}
		
		//print_r($this->coltype);
	}
	public function is_varchar($c) {
		preg_match('/varchar\(\d+\)/', $this->description[$c]['Type'], $matches);
		
		if ( empty($matches) ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function is_bool($c) {
		preg_match('/tinyint\(1\)/', $this->description[$c]['Type'], $matches);
		
		if ( empty($matches) ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function is_tinyint($c) {
		preg_match('/tinyint\(\d+\)/', $this->description[$c]['Type'], $matches);
		
		if ( empty($matches) ) {
			return FALSE;
		} else {
			if ( $this->is_bool($c) ) {
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
	public function post_delete() {
		if (isset($_POST["delete{$this->id}"]))
		{
			$id = $this->db->get_post("delete{$this->id}");
			
			$this->db->query_b("DELETE FROM `{$this->table}` WHERE id={$id}");
		}
	}
	public function post_update() {
		if (isset($_POST["update{$this->id}"])) {
			$id = $this->db->get_post("update{$this->id}");
			
			$all_post = TRUE;
			
			// verify all fields are posted
			/*
			for ( $i = 0; $i < count($this->col); ++$i ) {
				$c = $this->col[$i];
			*/
			foreach( $this->col as $c ) {
				if ( !($c=='id') ) {
					if ( !$this->is_bool($c) ) {
						if ( !isset($_POST[$c]) ){
							$all_post = FALSE;
							echo "error: not all fields posted</br>";
							$break;
						}
					}
				}
			}
			
			$str = "";
			$i = 0;
			if ( $all_post ) {
				foreach( $this->col as $c ) {
					if ( !($c=='id') ) {
						// append comma
						if ( $i > 0 ) {
							$str .= ",";
						}
						
						// determine value
						if ( $this->is_bool($c) ) {
							if ( isset($_POST[$c]) ) {
								//echo $c . " was posted!</br>";
								$v = 1;
							} else {
								$v = 0;
							}
						}
						else {
							$v = $this->db->get_post($c);
						}
						
						// append value
						$str .= $c . "='" . $v . "'";
						++$i;
					}
				}
				
				
				$this->db->query_b("UPDATE `{$this->table}` SET {$str} WHERE id={$id}");
			}
		}
	}
	public function post_sortby() {
		if (isset($_POST["sortby{$this->id}"])) {
			$sortby = $this->db->get_post("sortby{$this->id}");
			
			// determine direction
			$results = $this->db->query("
				SELECT * FROM `{$this->table}_sort`
				WHERE col='{$sortby}'
				");
			
			
			$dir = "";
			foreach ( $results as $row ) {
				$dir = $row['dir'];
			}
			
			// switch direction
			if (strcmp($dir,'ASC')==0) {
				$dir = 'DESC';
			}
			else {
				$dir = 'ASC';
			}
			
			$this->db->query_b("
				DELETE FROM `{$this->table}_sort`
				WHERE col='{$sortby}'
				");
			
			$this->db->query_b("
				INSERT INTO `{$this->table}_sort`
				(`col`,`dir`)
				VALUE
				('{$sortby}','{$dir}')
				");
		}
	}
	public function post() {
		$this->post_delete();
		$this->post_update();
		$this->post_sortby();
	}
	public function rows_reset() {
		$this->rows = "";
	}
	public function rows_add() {
		$this->rows .= <<<_END
					<tr>
{$this->cols}
					</tr>
_END;
		$this->cols_reset();
	}
	public function rows_add_item($id) {
		$this->rows .= <<<_END
					<tr>
						<form action='' method='post'>
{$this->cols}
						</form>

_END;
			if ( $this->del )
			{
				$this->rows .= <<<_END
						<form action='' method='post'>
							<td>
								<input type='submit' value='delete'></input>
								<input type='hidden' name='delete' value='{$id}'></input>
							</td>
						</form>

_END;
			}
			
			$this->rows .= <<<_END
					</tr>

_END;
		$this->cols_reset();
	}
	public function cols_reset() {
	$this->cols = "";
	}
	public function cols_add_header($str) {
		$this->cols .= <<<_END
						<td>
							<form action='' method='post'>
								<input type='submit' value='{$str}'></input>
								<input type='hidden' name='sortby' value='{$str}'></input>
							</form>
						</td>

_END;
	}
	public function cols_add_update($id) {
		if ( $this->up ) {
			$this->cols .= <<<_END
						<td>
							<input type='submit' value='update'></input>
							<input type='hidden' name='update' value='{$id}'></input>
						</td>

_END;
		}
	}
	public function cols_add($str) {
		$this->cols .= <<<_END
						<td>{$str}</td>

_END;
	}
	public function cols_add_item($col,$val) {
		if ($col=='id') {
			$this->cols .= <<<_END
						<td>{$val}</td>

_END;
		}
		else {
			if ( $this->is_varchar($col) ) {
				$this->cols .= <<<_END
						<td>
							<input class='long' type='text' name='{$col}' value='{$val}'></input>
						</td>

_END;
			}
			elseif ( $this->is_bool($col) ) {
				//echo "bool with val={$val}</br>";
				if ($val) {
					$checked = "checked='yes'";
				} else {
					$checked = "";
				}
				
				$this->cols .= <<<_END
						<td>
							<input type='checkbox' {$checked} name='{$col}' value='1'></input>
						</td>

_END;
			}
			else {
			$this->cols .= <<<_END
						<td>{$val}</td>

_END;
			}
		}
	}
	public function get_data() {
		
		// sortby string
		$results = $this->db->query("SELECT * FROM `{$this->table}_sort` ORDER BY `id` DESC");
		
		$sortstr = '';
		
		if ( !empty($results) ) {
			$sortstr = "ORDER BY ";
		}
		$i = 0;
		foreach ( $results as $row ) {
			if ( $i>0 ) { $sortstr .= ","; } 
			
			$col = $row['col'];
			$dir = $row['dir'];
			$sortstr .= "{$col} {$dir}";
			
			++$i;
		}
		
		// query string with optional search
		if (isset($_POST["search{$this->id}"])){
			$search = $this->db->get_post("search{$this->id}");
			
			$query = "CREATE OR REPLACE VIEW v AS SELECT * FROM `{$this->table}` WHERE `{$this->searchby}` LIKE '%{$search}%' {$sortstr}";
			
		}
		else {
			$query = "CREATE OR REPLACE VIEW v AS SELECT * FROM `{$this->table}` {$sortstr}";
		}
		
		// create view
		$this->db->query_b($query);
		
		// query string with optional filter
		$t0 = "v";
		$t1 = "{$this->table}_tag";
		$t2 = "{$this->table}_{$this->name}_tag_rel";
		$i0 = "{$this->name}_id";
		$i1 = "{$this->name}_tag_id";
		
		if ( $this->filter ) {
			$query = "
				SELECT * FROM `{$t0}`,`{$t1}`,`{$t2}`
				
				WHERE `{$t0}`.`id` = `{$t2}`.`{$i0}`
				AND   `{$t1}`.`id` = `{$t2}`.`{$i1}`
				AND   `{$t1}`.`selected` = 1
				GROUP BY `{$t0}`.`id`
				";
		}
		else {
			$query = "SELECT * FROM v";
		}
		
		// results array
		$results = $this->db->query($query);
		
		return $results;
	}
	public function echo_table() {
		$this->html .= "<p><table border=\"1\">{$this->rows}</table></p>";
		$this->rows_reset();
	}
	public function disp_search_form() {
		if ( !empty($this->searchby) ) {
		
			$this->html .= <<<_END
			<p>
				<table border="1">
					<form action='' method='post'>
						<tr>
							<td>search</td>
							<td><input type='text' name='search{$this->id}'></td>
						</tr>
						<tr>
							<td><input type='submit' value='search'></td>
						</tr>
					</form>
				</table>
			</p>
_END;
		}
	}
	public function disp() {
		// reset
		$this->html = '';
		
		$this->cols_reset();
		$this->rows_reset();
		
		// get data
		$results = $this->get_data();
		
		// column titles
		if ( is_string($this->col) ) {
			$this->cols_add_header($this->col);
		}
		elseif ( is_array($this->col) ) {
			foreach ( $this->col as $c ) {
				$this->cols_add_header($c);
			}
		}
		
		$this->rows_add();
		
		// items
		foreach ( $results as $row ) {
			if ( is_string($this->col) ) {
				$this->cols_add_item($this->col,$row[$this->col]);
			}
			elseif ( is_array($this->col) ) {
				foreach ( $this->col as $col ) {
					$this->cols_add_item($col,$row[$col]);
				}
			}
			
			$this->cols_add_update($row['id']);
			
			$this->rows_add_item($row['id']);
		}
		
		// echo search form
		$this->disp_search_form();
		
		// echo table
		$this->echo_table();
		
		return $this->html;
	}
}



?>
