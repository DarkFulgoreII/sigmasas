 
 <?php
 	
	require_once("puntaje.php");
	require_once("rubrica.php");
 	
 	class evaluacion 
 	{
 		//database
 		var $db;
 		//id
 		var $idevaluacion;
 		
		//simple attributes
		
		var $evaluacion; // (float)
		
		//collections
		
		var $puntaje_collection = array();
		
		//elements
		
		var $rubrica_element ;
		
		//table name
		var $evaluacion_table="evaluacion";
		
		//id field
		var $idevaluacion_field = "idevaluacion";
		
		//field names
		
		var $evaluacion_field="evaluacion";
		
		//relation table names
		
		// puntaje : 1-N relation
		//var $puntaje_table = "puntaje";
		var $puntaje_relN_field = "idpuntaje";
		var $puntaje_rel_table = "evaluacion_has_puntaje";
		// rubrica : 1-1 relation
		//var $rubrica_table = "rubrica";
		var $rubrica_rel1_field = "idrubrica";
		
		
		//constructor
		function evaluacion( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idevaluacion = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->evaluacion_table." WHERE ".$this->idevaluacion_field." = ".$this->idevaluacion;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->evaluacion = $this->db->f($this->evaluacion_field);
				//elements
				
				$this->rubrica_element = $this->db->f($this->rubrica_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_puntaje_collection()
		{
			$this->puntaje_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->puntaje_rel_table WHERE $this->idevaluacion = $this->idevaluacion_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new puntaje();
				$elemento->set_idpuntaje($this->db->f($this->puntaje_relN_field));
				$elemento->load();
				$this->puntaje_collection[] = $elemento;
			}
			return true;
		}
		function get_puntaje_collection()
		{
			$this->load_puntaje_collection();
			return $this->puntaje_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one evaluacion using a collection element (parent)
		
		
		function load_evaluacion_by_puntaje_inverse($idpuntaje)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->puntaje_rel_table WHERE $idpuntaje = $this->puntaje_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new evaluacion();
				$elemento->set_idevaluacion ($this->db->f($this->idevaluacion_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_rubrica_element()
		{
			$element = new rubrica();
			$element ->set_idrubrica( $this->rubrica_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->evaluacion_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->evaluacion_field.",";
			
			$dbQuery .= "$this->rubrica_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= "  $this->evaluacion ,";
			
			$dbQuery .= "$this->rubrica_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idevaluacion = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->evaluacion_table WHERE $this->idevaluacion_field = $this->idevaluacion ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->evaluacion_table SET ";
			
			
			
			$dbQuery .= "$this->evaluacion_field =  $this->evaluacion ,";
			
			$dbQuery .= "$this->rubrica_rel1_field = $this->rubrica_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idevaluacion_field = $this->idevaluacion ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_puntaje ($idpuntaje)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->puntaje_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idevaluacion_field,";
		   	$dbQuery .= " $this->puntaje_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idevaluacion,";
		   	$dbQuery .= " $idpuntaje";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_puntaje ($idpuntaje)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->puntaje_rel_table ";
			$dbQuery.= " WHERE $this->idevaluacion_field = $this->idevaluacion ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->puntaje_relN_field = $idpuntaje ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idevaluacion()
		{
			return $this->idevaluacion;
		}
 		function set_idevaluacion($id)
		{
			$this->idevaluacion=$id;
		}		
		//simple attributes
		
		function get_evaluacion()
		{
			return $this->evaluacion;
		}
		function set_evaluacion($value)
		{
			$this->evaluacion = $value;
		}
		
		//elements
		
		function set_rubrica_element($object)
		{	
			//update the foreign id based on the object
			$this->rubrica_element = $object->get_idrubrica();
		}
		
 	}
 ?>
 