 
 <?php
 	
	require_once("estudiante.php");
	require_once("usuario.php");
	require_once("usuario.php");
	require_once("grupo.php");
 	
 	class seccion 
 	{
 		//database
 		var $db;
 		//id
 		var $idseccion;
 		
		//simple attributes
		
		var $crn; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		var $estudiante_collection = array();
		var $usuario_collection = array();
		
		//elements
		
		var $usuario_element ;
		var $grupo_element ;
		
		//table name
		var $seccion_table="seccion";
		
		//id field
		var $idseccion_field = "idseccion";
		
		//field names
		
		var $crn_field="crn";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// estudiante : 1-N relation
		//var $estudiante_table = "estudiante";
		var $estudiante_relN_field = "idestudiante";
		var $estudiante_rel_table = "seccion_has_estudiante";
		// usuario : 1-N relation
		//var $usuario_table = "usuario";
		var $usuario_relN_field = "idusuario";
		var $usuario_rel_table = "seccion_has_usuario";
		// usuario : 1-1 relation
		//var $usuario_table = "usuario";
		var $usuario_rel1_field = "idusuario";
		
		// grupo : 1-1 relation
		//var $grupo_table = "grupo";
		var $grupo_rel1_field = "idgrupo";
		
		
		//constructor
		function seccion( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idseccion = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->seccion_table." WHERE ".$this->idseccion_field." = ".$this->idseccion;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->crn = $this->db->f($this->crn_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				$this->usuario_element = $this->db->f($this->usuario_rel1_field);
				$this->grupo_element = $this->db->f($this->grupo_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_estudiante_collection()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $this->idseccion = $this->idseccion_field";
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
		
		function load_usuario_collection()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->usuario_rel_table WHERE $this->idseccion = $this->idseccion_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new usuario();
				$elemento->set_idusuario($this->db->f($this->usuario_relN_field));
				$elemento->load();
				$this->usuario_collection[] = $elemento;
			}
			return true;
		}
		function get_usuario_collection()
		{
			$this->load_usuario_collection();
			return $this->usuario_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one seccion using a collection element (parent)
		
		
		function load_seccion_by_estudiante_inverse($idestudiante)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $idestudiante = $this->estudiante_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new seccion();
				$elemento->set_idseccion ($this->db->f($this->idseccion_field));
				$elemento->load();
				return $elemento;
			}
			return false;
		}
		
		
		function load_seccion_by_usuario_inverse($idusuario)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->usuario_rel_table WHERE $idusuario = $this->usuario_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new seccion();
				$elemento->set_idseccion ($this->db->f($this->idseccion_field));
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
		
		function get_grupo_element()
		{
			$element = new grupo();
			$element ->set_idgrupo( $this->grupo_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->seccion_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->crn_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery .= "$this->usuario_rel1_field,";
			$dbQuery .= "$this->grupo_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->crn',";
			$dbQuery .= " '$this->descripcion',";
			
			$dbQuery .= "$this->usuario_element,";
			$dbQuery .= "$this->grupo_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idseccion = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->seccion_table WHERE $this->idseccion_field = $this->idseccion ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->seccion_table SET ";
			
			
			
			$dbQuery .= "$this->crn_field = '$this->crn',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
			$dbQuery .= "$this->usuario_rel1_field = $this->usuario_element,";
			$dbQuery .= "$this->grupo_rel1_field = $this->grupo_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idseccion_field = $this->idseccion ";
			
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
		   	$dbQuery .= " $this->idseccion_field,";
		   	$dbQuery .= " $this->estudiante_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idseccion,";
		   	$dbQuery .= " $idestudiante";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_usuario ($idusuario)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->usuario_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idseccion_field,";
		   	$dbQuery .= " $this->usuario_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idseccion,";
		   	$dbQuery .= " $idusuario";
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
			$dbQuery.= " WHERE $this->idseccion_field = $this->idseccion ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->estudiante_relN_field = $idestudiante ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_usuario ($idusuario)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->usuario_rel_table ";
			$dbQuery.= " WHERE $this->idseccion_field = $this->idseccion ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->usuario_relN_field = $idusuario ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idseccion()
		{
			return $this->idseccion;
		}
 		function set_idseccion($id)
		{
			$this->idseccion=$id;
		}		
		//simple attributes
		
		function get_crn()
		{
			return $this->crn;
		}
		function set_crn($value)
		{
			$this->crn = $value;
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
		
		function set_usuario_element($object)
		{	
			//update the foreign id based on the object
			$this->usuario_element = $object->get_idusuario();
		}
		
		function set_grupo_element($object)
		{	
			//update the foreign id based on the object
			$this->grupo_element = $object->get_idgrupo();
		}
		
 	}
 ?>
 