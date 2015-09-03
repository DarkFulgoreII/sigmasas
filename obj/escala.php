 
 <?php
 	
 	
 	class escala 
 	{
 		//database
 		var $db;
 		//id
 		var $idescala;
 		
		//simple attributes
		
		var $descripcion; // (varchar)
		var $puntajeEscala; // (float)
		
		//collections
		
		
		//elements
		
		
		//table name
		var $escala_table="escala";
		
		//id field
		var $idescala_field = "idescala";
		
		//field names
		
		var $descripcion_field="descripcion";
		var $puntajeEscala_field="puntajeEscala";
		
		//relation table names
		
		
		//constructor
		function escala( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idescala = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->escala_table." WHERE ".$this->idescala_field." = ".$this->idescala;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->puntajeEscala = $this->db->f($this->puntajeEscala_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one escala using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->escala_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->puntajeEscala_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->puntajeEscala ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idescala = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->escala_table WHERE $this->idescala_field = $this->idescala ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->escala_table SET ";
			
			
			
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->puntajeEscala_field =  $this->puntajeEscala ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idescala_field = $this->idescala ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idescala()
		{
			return $this->idescala;
		}
 		function set_idescala($id)
		{
			$this->idescala=$id;
		}		
		//simple attributes
		
		function get_descripcion()
		{
			return $this->descripcion;
		}
		function set_descripcion($value)
		{
			$this->descripcion = $value;
		}
		
		function get_puntajeEscala()
		{
			return $this->puntajeEscala;
		}
		function set_puntajeEscala($value)
		{
			$this->puntajeEscala = $value;
		}
		
		//elements
		
 	}
 ?>
 