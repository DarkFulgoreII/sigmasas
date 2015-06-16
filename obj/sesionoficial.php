 
 <?php
 	
	require_once("bloque.php");
 	
 	class sesionoficial 
 	{
 		//database
 		var $db;
 		//id
 		var $idsesionoficial;
 		
		//simple attributes
		
		var $fecha;
		var $lugar;
		var $descripcion;
		
		//collections
		
		
		//elements
		
		var $bloque_element ;
		
		//table name
		var $sesionoficial_table="sesionoficial";
		
		//id field
		var $idsesionoficial_field = "idsesionoficial";
		
		//field names
		
		var $fecha_field="fecha";
		var $lugar_field="lugar";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// bloque : 1-1 relation
		//var $bloque_table = "bloque";
		var $bloque_rel1_field = "idbloque";
		
		
		//constructor
		function sesionoficial( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idsesionoficial = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->sesionoficial_table." WHERE ".$this->idsesionoficial_field." = ".$this->idsesionoficial;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->fecha = $this->db->f($this->fecha_field);
				$this->lugar = $this->db->f($this->lugar_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				$this->bloque_element = $this->db->f($this->bloque_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one sesionoficial using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_bloque_element()
		{
			$element = new bloque();
			$element ->set_idbloque( $this->bloque_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->sesionoficial_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->fecha_field.",";
			$dbQuery .= $this->lugar_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery .= "$this->bloque_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->fecha',";
			$dbQuery .= " '$this->lugar',";
			$dbQuery .= "  $this->descripcion ,";
			
			$dbQuery .= "$this->bloque_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idsesionoficial = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->sesionoficial_table WHERE $this->idsesionoficial_field = $this->idsesionoficial ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->sesionoficial_table SET ";
			
			
			
			$dbQuery .= "$this->fecha_field = '$this->fecha',";
			$dbQuery .= "$this->lugar_field = '$this->lugar',";
			$dbQuery .= "$this->descripcion_field =  $this->descripcion ,";
			
			$dbQuery .= "$this->bloque_rel1_field = $this->bloque_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idsesionoficial_field = $this->idsesionoficial ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idsesionoficial()
		{
			return $this->idsesionoficial;
		}
 		function set_idsesionoficial($id)
		{
			$this->idsesionoficial=$id;
		}		
		//simple attributes
		
		function get_fecha()
		{
			return $this->fecha;
		}
		function set_fecha($value)
		{
			$this->fecha = $value;
		}
		
		function get_lugar()
		{
			return $this->lugar;
		}
		function set_lugar($value)
		{
			$this->lugar = $value;
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
		
		function set_bloque_element($object)
		{	
			//update the foreign id based on the object
			$this->bloque_element = $object->get_idbloque();
		}
		
 	}
 ?>
 