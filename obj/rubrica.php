 
 <?php
 	
	require_once("criterio.php");
 	
 	class rubrica 
 	{
 		//database
 		var $db;
 		//id
 		var $idrubrica;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		var $criterio_collection = array();
		
		//elements
		
		
		//table name
		var $rubrica_table="rubrica";
		
		//id field
		var $idrubrica_field = "idrubrica";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// criterio : 1-N relation
		//var $criterio_table = "criterio";
		var $criterio_relN_field = "idcriterio";
		var $criterio_rel_table = "rubrica_has_criterio";
		
		//constructor
		function rubrica( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idrubrica = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->rubrica_table." WHERE ".$this->idrubrica_field." = ".$this->idrubrica;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_criterio_collection()
		{
			$this->criterio_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->criterio_rel_table WHERE $this->idrubrica = $this->idrubrica_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new criterio();
				$elemento->set_idcriterio($this->db->f($this->criterio_relN_field));
				$elemento->load();
				$this->criterio_collection[] = $elemento;
			}
			return true;
		}
		function get_criterio_collection()
		{
			$this->load_criterio_collection();
			return $this->criterio_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one rubrica using a collection element (parent)
		
		
		function load_rubrica_by_criterio_inverse($idcriterio)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->criterio_rel_table WHERE $idcriterio = $this->criterio_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new rubrica();
				$elemento->set_idrubrica ($this->db->f($this->idrubrica_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->rubrica_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idrubrica = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->rubrica_table WHERE $this->idrubrica_field = $this->idrubrica ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->rubrica_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idrubrica_field = $this->idrubrica ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_criterio ($idcriterio)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->criterio_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idrubrica_field,";
		   	$dbQuery .= " $this->criterio_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idrubrica,";
		   	$dbQuery .= " $idcriterio";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_criterio ($idcriterio)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->criterio_rel_table ";
			$dbQuery.= " WHERE $this->idrubrica_field = $this->idrubrica ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->criterio_relN_field = $idcriterio ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idrubrica()
		{
			return $this->idrubrica;
		}
 		function set_idrubrica($id)
		{
			$this->idrubrica=$id;
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
		
		//elements
		
 	}
 ?>
 