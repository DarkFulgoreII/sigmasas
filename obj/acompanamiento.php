 
 <?php
 	
	require_once("estudiante.php");
	require_once("usuario.php");
 	
 	class acompanamiento 
 	{
 		//database
 		var $db;
 		//id
 		var $idacompanamiento;
 		
		//simple attributes
		
		var $comentario;
		var $asunto;
		var $curso;
		
		//collections
		
		var $estudiante_collection = array();
		
		//elements
		
		var $usuario_element ;
		
		//table name
		var $acompanamiento_table="acompanamiento";
		
		//id field
		var $idacompanamiento_field = "idacompanamiento";
		
		//field names
		
		var $comentario_field="comentario";
		var $asunto_field="asunto";
		var $curso_field="curso";
		
		//relation table names
		
		// estudiante : 1-N relation
		//var $estudiante_table = "estudiante";
		var $estudiante_relN_field = "idestudiante";
		var $estudiante_rel_table = "acompanamiento_has_estudiante";
		// usuario : 1-1 relation
		//var $usuario_table = "usuario";
		var $usuario_rel1_field = "idusuario";
		
		
		//constructor
		function acompanamiento( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idacompanamiento = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->acompanamiento_table." WHERE ".$this->idacompanamiento_field." = ".$this->idacompanamiento;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->comentario = $this->db->f($this->comentario_field);
				$this->asunto = $this->db->f($this->asunto_field);
				$this->curso = $this->db->f($this->curso_field);
				//elements
				
				$this->usuario_element = $this->db->f($this->usuario_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_estudiante_collection()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $this->idacompanamiento = $this->idacompanamiento_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new estudiante();
				$elemento->set_idestudiante($this->db->f($this->estudiante_relN_field));
				$elemento->load();
				$this->estudiante_collection[] = $elemento;
			}
			return true;
		}
		function get_estudiante_collection()
		{
			$this->load_estudiante_collection();
			return $this->estudiante_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one acompanamiento using a collection element (parent)
		
		
		function load_acompanamiento_by_estudiante_inverse($idestudiante)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $idestudiante = $this->estudiante_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new acompanamiento();
				$elemento->set_idacompanamiento ($this->db->f($this->idacompanamiento_field));
				$elemento->load();
				return $elemento;
			}
			return false;
		}
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_usuario_element()
		{
			$element = new usuario();
			$element ->set_idusuario( $this->usuario_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->acompanamiento_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->comentario_field.",";
			$dbQuery .= $this->asunto_field.",";
			$dbQuery .= $this->curso_field.",";
			
			$dbQuery .= "$this->usuario_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->comentario',";
			$dbQuery .= " '$this->asunto',";
			$dbQuery .= " '$this->curso',";
			
			$dbQuery .= "$this->usuario_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idacompanamiento = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->acompanamiento_table WHERE $this->idacompanamiento_field = $this->idacompanamiento ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->acompanamiento_table SET ";
			
			
			
			$dbQuery .= "$this->comentario_field = '$this->comentario',";
			$dbQuery .= "$this->asunto_field = '$this->asunto',";
			$dbQuery .= "$this->curso_field = '$this->curso',";
			
			$dbQuery .= "$this->usuario_rel1_field = $this->usuario_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idacompanamiento_field = $this->idacompanamiento ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_estudiante ($idestudiante)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->estudiante_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idacompanamiento_field,";
		   	$dbQuery .= " $this->estudiante_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idacompanamiento,";
		   	$dbQuery .= " $idestudiante";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_estudiante ($idestudiante)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->estudiante_rel_table ";
			$dbQuery.= " WHERE $this->idacompanamiento_field = $this->idacompanamiento ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->estudiante_relN_field = $idestudiante ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idacompanamiento()
		{
			return $this->idacompanamiento;
		}
 		function set_idacompanamiento($id)
		{
			$this->idacompanamiento=$id;
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
		
		function get_asunto()
		{
			return $this->asunto;
		}
		function set_asunto($value)
		{
			$this->asunto = $value;
		}
		
		function get_curso()
		{
			return $this->curso;
		}
		function set_curso($value)
		{
			$this->curso = $value;
		}
		
		//elements
		
		function set_usuario_element($object)
		{	
			//update the foreign id based on the object
			$this->usuario_element = $object->get_idusuario();
		}
		
 	}
 ?>
 