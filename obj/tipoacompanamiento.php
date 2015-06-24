 
 <?php
 	
 	
 	class tipoacompanamiento 
 	{
 		//database
 		var $db;
 		//id
 		var $idtipoacompanamiento;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		
		//collections
		
		
		//elements
		
		
		//table name
		var $tipoacompanamiento_table="tipoacompanamiento";
		
		//id field
		var $idtipoacompanamiento_field = "idtipoacompanamiento";
		
		//field names
		
		var $nombre_field="nombre";
		
		//relation table names
		
		
		//constructor
		function tipoacompanamiento( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idtipoacompanamiento = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->tipoacompanamiento_table." WHERE ".$this->idtipoacompanamiento_field." = ".$this->idtipoacompanamiento;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one tipoacompanamiento using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->tipoacompanamiento_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idtipoacompanamiento = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->tipoacompanamiento_table WHERE $this->idtipoacompanamiento_field = $this->idtipoacompanamiento ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->tipoacompanamiento_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idtipoacompanamiento_field = $this->idtipoacompanamiento ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idtipoacompanamiento()
		{
			return $this->idtipoacompanamiento;
		}
 		function set_idtipoacompanamiento($id)
		{
			$this->idtipoacompanamiento=$id;
		}		
		//simple attributes
		
		function get_nombre()
		{
			return $this->nombre;
		}
		function set_nombre($value)
		{
			$this->nombre = $value;
		}
		
		//elements
		
 	}
 ?>
 