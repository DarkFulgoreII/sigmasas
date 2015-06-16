 
 <?php
 	
 	
 	class bloque 
 	{
 		//database
 		var $db;
 		//id
 		var $idbloque;
 		
		//simple attributes
		
		var $descripcion;
		var $orden;
		var $mostrar;
		
		//collections
		
		
		//elements
		
		
		//table name
		var $bloque_table="bloque";
		
		//id field
		var $idbloque_field = "idbloque";
		
		//field names
		
		var $descripcion_field="descripcion";
		var $orden_field="orden";
		var $mostrar_field="mostrar";
		
		//relation table names
		
		
		//constructor
		function bloque( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idbloque = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->bloque_table." WHERE ".$this->idbloque_field." = ".$this->idbloque;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->orden = $this->db->f($this->orden_field);
				$this->mostrar = $this->db->f($this->mostrar_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one bloque using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->bloque_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->orden_field.",";
			$dbQuery .= $this->mostrar_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->orden ,";
			if($this->mostrar == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idbloque = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->bloque_table WHERE $this->idbloque_field = $this->idbloque ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->bloque_table SET ";
			
			
			
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->orden_field =  $this->orden ,";
			$dbQuery .= "$this->mostrar_field = ";
			if($this->mostrar == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idbloque_field = $this->idbloque ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idbloque()
		{
			return $this->idbloque;
		}
 		function set_idbloque($id)
		{
			$this->idbloque=$id;
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
		
		function get_orden()
		{
			return $this->orden;
		}
		function set_orden($value)
		{
			$this->orden = $value;
		}
		
		function get_mostrar()
		{
			return $this->mostrar;
		}
		function set_mostrar($value)
		{
			$this->mostrar = $value;
		}
		
		//elements
		
 	}
 ?>
 