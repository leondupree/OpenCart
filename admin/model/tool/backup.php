<?php
class ModelToolBackup extends Model {
	public function restore($sql) {
		foreach (explode(";\n", $sql) as $sql) {
    		$sql = trim($sql);
    		
			if ($sql) {
      			$this->db->query($sql);
    		}
  		}
	}
	
	public function backup() {
		$output = '';
		
		$table_query = $this->db->query("SHOW TABLES FROM `'" . DB_DATABASE . "`");

		foreach ($table_query->rows as $table) {
			if (DB_PREFIX) {
				if (strpos($table['Tables_in_' . DB_DATABASE], DB_PREFIX) === FALSE) {
					$status = FALSE;
				} else {
					$status = TRUE;
				}
			} else {
				$status = TRUE;
			}
			
			if ($status) {
				$output .= 'TRUNCATE TABLE `' . $table['Tables_in_' . DB_DATABASE] . '`;' . "\n\n";
			
				$query = $this->db->query("SELECT * FROM `" . $table['Tables_in_' . DB_DATABASE] . "`");
				
				foreach ($query->rows as $result) {
					$fields = '';
					
					foreach (array_keys($result) as $value) {
						$fields .= '`' . $value . '`, ';
					}
					
					$values = '';
					
					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);			
						
						$values .= '\'' . $value . '\', ';
					}
					
					$output .= 'INSERT INTO `' . $table['Tables_in_' . DB_DATABASE] . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}
				
				$output .= "\n\n";
			}
		}

		return $output;	
	}
}
?>