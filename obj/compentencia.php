 
 <?php
 	
 	
 	class compentencia 
 	{
 		//database
 		var $db;
 		//id
 		var $idcompentencia;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		
		//elements
		
		
		//table name
		var $compentencia_table="compentencia";
		
		//id field
		var $idcompentencia_field = "idcompentencia";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		
		//constructor
		function compentencia( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idcompentencia = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->compentencia_table." WHERE ".$this->idcompentencia_field." = ".$this->idcompentencia;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one compentencia using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->compentencia_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idcompentencia = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->compentencia_table WHERE $this->idcompentencia_field = $this->idcompentencia ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->compentencia_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idcompentencia_field = $this->idcompentencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idcompentencia()
		{
			return $this->idcompentencia;
		}
 		function set_idcompentencia($id)
		{
			$this->idcompentencia=$id;
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
		
		function get_descripcion()
		{
			return $this->descripcion;
		}
		function set_descripcion($value)
		{
			$this->descripcion = $value;
		}
		
		//elements
		
 	}
 ?>
 