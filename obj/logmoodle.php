 
 <?php
 	
	require_once("seccion.php");
 	
 	class logmoodle 
 	{
 		//database
 		var $db;
 		//id
 		var $idlogmoodle;
 		
		//simple attributes
		
		var $nombreusuario; // (varchar)
		var $nombreevento; // (varchar)
		var $descripcion; // (varchar)
		var $origen; // (varchar)
		var $direccionip; // (varchar)
		var $usuarioafectado; // (varchar)
		var $contextoevento; // (varchar)
		var $componente; // (varchar)
		
		//collections
		
		
		//elements
		
		var $seccion_element ;
		
		//table name
		var $logmoodle_table="logmoodle";
		
		//id field
		var $idlogmoodle_field = "idlogmoodle";
		
		//field names
		
		var $nombreusuario_field="nombreusuario";
		var $nombreevento_field="nombreevento";
		var $descripcion_field="descripcion";
		var $origen_field="origen";
		var $direccionip_field="direccionip";
		var $usuarioafectado_field="usuarioafectado";
		var $contextoevento_field="contextoevento";
		var $componente_field="componente";
		
		//relation table names
		
		// seccion : 1-1 relation
		//var $seccion_table = "seccion";
		var $seccion_rel1_field = "idseccion";
		
		
		//constructor
		function logmoodle( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idlogmoodle = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->logmoodle_table." WHERE ".$this->idlogmoodle_field." = ".$this->idlogmoodle;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombreusuario = $this->db->f($this->nombreusuario_field);
				$this->nombreevento = $this->db->f($this->nombreevento_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->origen = $this->db->f($this->origen_field);
				$this->direccionip = $this->db->f($this->direccionip_field);
				$this->usuarioafectado = $this->db->f($this->usuarioafectado_field);
				$this->contextoevento = $this->db->f($this->contextoevento_field);
				$this->componente = $this->db->f($this->componente_field);
				//elements
				
				$this->seccion_element = $this->db->f($this->seccion_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one logmoodle using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_seccion_element()
		{
			$element = new seccion();
			$element ->set_idseccion( $this->seccion_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->logmoodle_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombreusuario_field.",";
			$dbQuery .= $this->nombreevento_field.",";
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->origen_field.",";
			$dbQuery .= $this->direccionip_field.",";
			$dbQuery .= $this->usuarioafectado_field.",";
			$dbQuery .= $this->contextoevento_field.",";
			$dbQuery .= $this->componente_field.",";
			
			$dbQuery .= "$this->seccion_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombreusuario',";
			$dbQuery .= " '$this->nombreevento',";
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= " '$this->origen',";
			$dbQuery .= " '$this->direccionip',";
			$dbQuery .= " '$this->usuarioafectado',";
			$dbQuery .= " '$this->contextoevento',";
			$dbQuery .= " '$this->componente',";
			
			$dbQuery .= "$this->seccion_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idlogmoodle = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->logmoodle_table WHERE $this->idlogmoodle_field = $this->idlogmoodle ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->logmoodle_table SET ";
			
			
			
			$dbQuery .= "$this->nombreusuario_field = '$this->nombreusuario',";
			$dbQuery .= "$this->nombreevento_field = '$this->nombreevento',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->origen_field = '$this->origen',";
			$dbQuery .= "$this->direccionip_field = '$this->direccionip',";
			$dbQuery .= "$this->usuarioafectado_field = '$this->usuarioafectado',";
			$dbQuery .= "$this->contextoevento_field = '$this->contextoevento',";
			$dbQuery .= "$this->componente_field = '$this->componente',";
			
			$dbQuery .= "$this->seccion_rel1_field = $this->seccion_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idlogmoodle_field = $this->idlogmoodle ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idlogmoodle()
		{
			return $this->idlogmoodle;
		}
 		function set_idlogmoodle($id)
		{
			$this->idlogmoodle=$id;
		}		
		//simple attributes
		
		function get_nombreusuario()
		{
			return $this->nombreusuario;
		}
		function set_nombreusuario($value)
		{
			$this->nombreusuario = $value;
		}
		
		function get_nombreevento()
		{
			return $this->nombreevento;
		}
		function set_nombreevento($value)
		{
			$this->nombreevento = $value;
		}
		
		function get_descripcion()
		{
			return $this->descripcion;
		}
		function set_descripcion($value)
		{
			$this->descripcion = $value;
		}
		
		function get_origen()
		{
			return $this->origen;
		}
		function set_origen($value)
		{
			$this->origen = $value;
		}
		
		function get_direccionip()
		{
			return $this->direccionip;
		}
		function set_direccionip($value)
		{
			$this->direccionip = $value;
		}
		
		function get_usuarioafectado()
		{
			return $this->usuarioafectado;
		}
		function set_usuarioafectado($value)
		{
			$this->usuarioafectado = $value;
		}
		
		function get_contextoevento()
		{
			return $this->contextoevento;
		}
		function set_contextoevento($value)
		{
			$this->contextoevento = $value;
		}
		
		function get_componente()
		{
			return $this->componente;
		}
		function set_componente($value)
		{
			$this->componente = $value;
		}
		
		//elements
		
		function set_seccion_element($object)
		{	
			//update the foreign id based on the object
			$this->seccion_element = $object->get_idseccion();
		}
		
 	}
 ?>
 