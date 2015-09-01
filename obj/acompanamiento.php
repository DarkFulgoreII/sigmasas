 
 <?php
 	
	require_once("estudiante.php");
	require_once("aspecto.php");
	require_once("usuario.php");
	require_once("tipoacompanamiento.php");
 	
 	class acompanamiento 
 	{
 		//database
 		var $db;
 		//id
 		var $idacompanamiento;
 		
		//simple attributes
		
		var $comentario; // (varchar)
		var $asunto; // (varchar)
		var $curso; // (varchar)
		var $fecha; // (date)
		var $registradapor; // (varchar)
		
		//collections
		
		var $estudiante_collection = array();
		var $aspecto_collection = array();
		
		//elements
		
		var $usuario_element ;
		var $tipoacompanamiento_element ;
		
		//table name
		var $acompanamiento_table="acompanamiento";
		
		//id field
		var $idacompanamiento_field = "idacompanamiento";
		
		//field names
		
		var $comentario_field="comentario";
		var $asunto_field="asunto";
		var $curso_field="curso";
		var $fecha_field="fecha";
		var $registradapor_field="registradapor";
		
		//relation table names
		
		// estudiante : 1-N relation
		//var $estudiante_table = "estudiante";
		var $estudiante_relN_field = "idestudiante";
		var $estudiante_rel_table = "acompanamiento_has_estudiante";
		// aspecto : 1-N relation
		//var $aspecto_table = "aspecto";
		var $aspecto_relN_field = "idaspecto";
		var $aspecto_rel_table = "acompanamiento_has_aspecto";
		// usuario : 1-1 relation
		//var $usuario_table = "usuario";
		var $usuario_rel1_field = "idusuario";
		
		// tipoacompanamiento : 1-1 relation
		//var $tipoacompanamiento_table = "tipoacompanamiento";
		var $tipoacompanamiento_rel1_field = "idtipoacompanamiento";
		
		
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
				$this->fecha = $this->db->f($this->fecha_field);
				$this->registradapor = $this->db->f($this->registradapor_field);
				//elements
				
				$this->usuario_element = $this->db->f($this->usuario_rel1_field);
				$this->tipoacompanamiento_element = $this->db->f($this->tipoacompanamiento_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_estudiante_collection()
		{
			$this->estudiante_collection = array();
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
		
		function load_aspecto_collection()
		{
			$this->aspecto_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->aspecto_rel_table WHERE $this->idacompanamiento = $this->idacompanamiento_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new aspecto();
				$elemento->set_idaspecto($this->db->f($this->aspecto_relN_field));
				$elemento->load();
				$this->aspecto_collection[] = $elemento;
			}
			return true;
		}
		function get_aspecto_collection()
		{
			$this->load_aspecto_collection();
			return $this->aspecto_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one acompanamiento using a collection element (parent)
		
		
		function load_acompanamiento_by_estudiante_inverse($idestudiante)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $idestudiante = $this->estudiante_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new acompanamiento();
				$elemento->set_idacompanamiento ($this->db->f($this->idacompanamiento_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_acompanamiento_by_aspecto_inverse($idaspecto)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->aspecto_rel_table WHERE $idaspecto = $this->aspecto_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new acompanamiento();
				$elemento->set_idacompanamiento ($this->db->f($this->idacompanamiento_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_usuario_element()
		{
			$element = new usuario();
			$element ->set_idusuario( $this->usuario_element );
			$element->load();
			return $element;
		}
		
		function get_tipoacompanamiento_element()
		{
			$element = new tipoacompanamiento();
			$element ->set_idtipoacompanamiento( $this->tipoacompanamiento_element );
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
			$dbQuery .= $this->fecha_field.",";
			$dbQuery .= $this->registradapor_field.",";
			
			$dbQuery .= "$this->usuario_rel1_field,";
			$dbQuery .= "$this->tipoacompanamiento_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->comentario',";
			$dbQuery .= " '$this->asunto',";
			$dbQuery .= " '$this->curso',";
			$dbQuery .= " '$this->fecha',";
			$dbQuery .= " '$this->registradapor',";
			
			$dbQuery .= "$this->usuario_element,";
			$dbQuery .= "$this->tipoacompanamiento_element,";
		   	
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
			$dbQuery .= "$this->fecha_field = '$this->fecha',";
			$dbQuery .= "$this->registradapor_field = '$this->registradapor',";
			
			$dbQuery .= "$this->usuario_rel1_field = $this->usuario_element,";
			$dbQuery .= "$this->tipoacompanamiento_rel1_field = $this->tipoacompanamiento_element,";
		   	
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
		
		function add_aspecto ($idaspecto)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->aspecto_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idacompanamiento_field,";
		   	$dbQuery .= " $this->aspecto_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idacompanamiento,";
		   	$dbQuery .= " $idaspecto";
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
		
		function remove_aspecto ($idaspecto)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->aspecto_rel_table ";
			$dbQuery.= " WHERE $this->idacompanamiento_field = $this->idacompanamiento ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->aspecto_relN_field = $idaspecto ";
			
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
		
		function get_fecha()
		{
			return $this->fecha;
		}
		function set_fecha($value)
		{
			$this->fecha = $value;
		}
		
		function get_registradapor()
		{
			return $this->registradapor;
		}
		function set_registradapor($value)
		{
			$this->registradapor = $value;
		}
		
		//elements
		
		function set_usuario_element($object)
		{	
			//update the foreign id based on the object
			$this->usuario_element = $object->get_idusuario();
		}
		
		function set_tipoacompanamiento_element($object)
		{	
			//update the foreign id based on the object
			$this->tipoacompanamiento_element = $object->get_idtipoacompanamiento();
		}
		
 	}
 ?>
 