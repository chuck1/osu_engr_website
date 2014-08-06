<?php

class COMBO {
	public $name;
	public $db;
	public $table;
	public $col;
	public $id = 1;
	
	public function __construct($name,$db,$table,$col) {
		$this->db = $db;
		$this->name = $name;
		$this->table = $this->db->nickname . "_" . $table;
		$this->col = $col;
	}
	public function disp() {
		$results = $this->db->query("SELECT * FROM `{$this->table}`");
		
		foreach ( $results as $row ) {
			if ( $row['id'] == $this->id ) {
				$s = " selected";
			} else {
				$s = "";
			}
			
			if ( is_string($this->col) ) {
				$val = $row[$this->col];
			}
			elseif ( is_array($this->col) ) {
				$val = "";
				foreach ( $this->col as $c ) {
					$val .= $row[$c] . " ";
				}
			}
			$options .= "<option value={$row['id']}{$s}>{$val}</option>";
		}
		
		$name = $this->name;
		//echo $name . "</br>";
		$ret = <<<_END
		<select name="{$name}">
			{$options}
		</select>

_END;
		return $ret;
	}
}

?>