 
 <?php
 	
	require_once("criterio.php");
	require_once("escala.php");
 	
 	class puntaje 
 	{
 		//database
 		var $db;
 		//id
 		var $idpuntaje;
 		
		//simple attributes
		
		var $comentario; // (varchar)
		var $puntaje; // (float)
		
		//collections
		
		
		//elements
		
		var $criterio_element ;
		var $escala_element ;
		
		//table name
		var $puntaje_table="puntaje";
		
		//id field
		var $idpuntaje_field = "idpuntaje";
		
		//field names
		
		var $comentario_field="comentario";
		var $puntaje_field="puntaje";
		
		//relation table names
		
		// criterio : 1-1 relation
		//var $criterio_table = "criterio";
		var $criterio_rel1_field = "idcriterio";
		
		// escala : 1-1 relation
		//var $escala_table = "escala";
		var $escala_rel1_field = "idescala";
		
		
		//constructor
		function puntaje( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idpuntaje = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->puntaje_table." WHERE ".$this->idpuntaje_field." = ".$this->idpuntaje;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->comentario = $this->db->f($this->comentario_field);
				$this->puntaje = $this->db->f($this->puntaje_field);
				//elements
				
				$this->criterio_element = $this->db->f($this->criterio_rel1_field);
				$this->escala_element = $this->db->f($this->escala_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one puntaje using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_criterio_element()
		{
			$element = new criterio();
			$element ->set_idcriterio( $this->criterio_element );
			$element->load();
			return $element;
		}
		
		function get_escala_element()
		{
			$element = new escala();
			$element ->set_idescala( $this->escala_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->puntaje_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->comentario_field.",";
			$dbQuery .= $this->puntaje_field.",";
			
			$dbQuery .= "$this->criterio_rel1_field,";
			$dbQuery .= "$this->escala_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->comentario',";
			$dbQuery .= "  $this->puntaje ,";
			
			$dbQuery .= "$this->criterio_element,";
			$dbQuery .= "$this->escala_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idpuntaje = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->puntaje_table WHERE $this->idpuntaje_field = $this->idpuntaje ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->puntaje_table SET ";
			
			
			
			$dbQuery .= "$this->comentario_field = '$this->comentario',";
			$dbQuery .= "$this->puntaje_field =  $this->puntaje ,";
			
			$dbQuery .= "$this->criterio_rel1_field = $this->criterio_element,";
			$dbQuery .= "$this->escala_rel1_field = $this->escala_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idpuntaje_field = $this->idpuntaje ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idpuntaje()
		{
			return $this->idpuntaje;
		}
 		function set_idpuntaje($id)
		{
			$this->idpuntaje=$id;
		}		
		//simple attributes
		
		function get_comentario()
		{
			return $this->comentario;
		}
		function set_comentario($value)
		{
			$this->comentario = $value;
		}
		
		function get_puntaje()
		{
			return $this->puntaje;
		}
		function set_puntaje($value)
		{
			$this->puntaje = $value;
		}
		
		//elements
		
		function set_criterio_element($object)
		{	
			//update the foreign id based on the object
			$this->criterio_element = $object->get_idcriterio();
		}
		
		function set_escala_element($object)
		{	
			//update the foreign id based on the object
			$this->escala_element = $object->get_idescala();
		}
		
 	}
 ?>
 