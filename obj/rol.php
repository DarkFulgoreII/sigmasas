 
 <?php
 	
 	
 	class rol 
 	{
 		//database
 		var $db;
 		//id
 		var $idrol;
 		
		//simple attributes
		
		var $nombre;
		
		//collections
		
		
		//elements
		
		
		//table name
		var $rol_table="rol";
		
		//id field
		var $idrol_field = "idrol";
		
		//field names
		
		var $nombre_field="nombre";
		
		//relation table names
		
		
		//constructor
		function rol( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idrol = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->rol_table." WHERE ".$this->idrol_field." = ".$this->idrol;
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
		
		//LOAD RELATIONS -N (INVERSE) load one rol using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->rol_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idrol = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->rol_table WHERE $this->idrol_field = $this->idrol ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->rol_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idrol_field = $this->idrol ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idrol()
		{
			return $this->idrol;
		}
 		function set_idrol($id)
		{
			$this->idrol=$id;
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
 