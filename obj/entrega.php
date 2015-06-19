 
 <?php
 	
	require_once("actividad.php");
 	
 	class entrega 
 	{
 		//database
 		var $db;
 		//id
 		var $identrega;
 		
		//simple attributes
		
		var $realizada; // (tinyint)
		var $comentario; // (varchar)
		var $registradapor; // (varchar)
		var $calificacion; // (float)
		
		//collections
		
		
		//elements
		
		var $actividad_element ;
		
		//table name
		var $entrega_table="entrega";
		
		//id field
		var $identrega_field = "identrega";
		
		//field names
		
		var $realizada_field="realizada";
		var $comentario_field="comentario";
		var $registradapor_field="registradapor";
		var $calificacion_field="calificacion";
		
		//relation table names
		
		// actividad : 1-1 relation
		//var $actividad_table = "actividad";
		var $actividad_rel1_field = "idactividad";
		
		
		//constructor
		function entrega( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->identrega = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->entrega_table." WHERE ".$this->identrega_field." = ".$this->identrega;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->realizada = $this->db->f($this->realizada_field);
				$this->comentario = $this->db->f($this->comentario_field);
				$this->registradapor = $this->db->f($this->registradapor_field);
				$this->calificacion = $this->db->f($this->calificacion_field);
				//elements
				
				$this->actividad_element = $this->db->f($this->actividad_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one entrega using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_actividad_element()
		{
			$element = new actividad();
			$element ->set_idactividad( $this->actividad_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->entrega_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->realizada_field.",";
			$dbQuery .= $this->comentario_field.",";
			$dbQuery .= $this->registradapor_field.",";
			$dbQuery .= $this->calificacion_field.",";
			
			$dbQuery .= "$this->actividad_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			if($this->realizada == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= " '$this->comentario',";
			$dbQuery .= " '$this->registradapor',";
			$dbQuery .= "  $this->calificacion ,";
			
			$dbQuery .= "$this->actividad_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->identrega = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->entrega_table WHERE $this->identrega_field = $this->identrega ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->entrega_table SET ";
			
			
			
			$dbQuery .= "$this->realizada_field = ";
			if($this->realizada == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "$this->comentario_field = '$this->comentario',";
			$dbQuery .= "$this->registradapor_field = '$this->registradapor',";
			$dbQuery .= "$this->calificacion_field =  $this->calificacion ,";
			
			$dbQuery .= "$this->actividad_rel1_field = $this->actividad_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->identrega_field = $this->identrega ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_identrega()
		{
			return $this->identrega;
		}
 		function set_identrega($id)
		{
			$this->identrega=$id;
		}		
		//simple attributes
		
		function get_realizada()
		{
			return $this->realizada;
		}
		function set_realizada($value)
		{
			$this->realizada = $value;
		}
		
		function get_comentario()
		{
			return $this->comentario;
		}
		function set_comentario($value)
		{
			$this->comentario = $value;
		}
		
		function get_registradapor()
		{
			return $this->registradapor;
		}
		function set_registradapor($value)
		{
			$this->registradapor = $value;
		}
		
		function get_calificacion()
		{
			return $this->calificacion;
		}
		function set_calificacion($value)
		{
			$this->calificacion = $value;
		}
		
		//elements
		
		function set_actividad_element($object)
		{	
			//update the foreign id based on the object
			$this->actividad_element = $object->get_idactividad();
		}
		
 	}
 ?>
 