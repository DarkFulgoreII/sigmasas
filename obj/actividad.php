 
 <?php
 	
 	
 	class actividad 
 	{
 		//database
 		var $db;
 		//id
 		var $idactividad;
 		
		//simple attributes
		
		var $nombre;
		var $descripcion;
		var $numerosemana;
		
		//collections
		
		
		//elements
		
		
		//table name
		var $actividad_table="actividad";
		
		//id field
		var $idactividad_field = "idactividad";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		var $numerosemana_field="numerosemana";
		
		//relation table names
		
		
		//constructor
		function actividad( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idactividad = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->actividad_table." WHERE ".$this->idactividad_field." = ".$this->idactividad;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->numerosemana = $this->db->f($this->numerosemana_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one actividad using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->actividad_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->numerosemana_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->numerosemana ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idactividad = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->actividad_table WHERE $this->idactividad_field = $this->idactividad ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->actividad_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->numerosemana_field =  $this->numerosemana ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idactividad_field = $this->idactividad ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idactividad()
		{
			return $this->idactividad;
		}
 		function set_idactividad($id)
		{
			$this->idactividad=$id;
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
		
		function get_numerosemana()
		{
			return $this->numerosemana;
		}
		function set_numerosemana($value)
		{
			$this->numerosemana = $value;
		}
		
		//elements
		
 	}
 ?>
 