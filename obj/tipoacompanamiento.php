 
 <?php
 	
	require_once("categoria.php");
 	
 	class tipoacompanamiento 
 	{
 		//database
 		var $db;
 		//id
 		var $idtipoacompanamiento;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		
		//collections
		
		var $categoria_collection = array();
		
		//elements
		
		
		//table name
		var $tipoacompanamiento_table="tipoacompanamiento";
		
		//id field
		var $idtipoacompanamiento_field = "idtipoacompanamiento";
		
		//field names
		
		var $nombre_field="nombre";
		
		//relation table names
		
		// categoria : 1-N relation
		//var $categoria_table = "categoria";
		var $categoria_relN_field = "idcategoria";
		var $categoria_rel_table = "tipoacompanamiento_has_categoria";
		
		//constructor
		function tipoacompanamiento( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idtipoacompanamiento = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->tipoacompanamiento_table." WHERE ".$this->idtipoacompanamiento_field." = ".$this->idtipoacompanamiento;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_categoria_collection()
		{
			$this->categoria_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->categoria_rel_table WHERE $this->idtipoacompanamiento = $this->idtipoacompanamiento_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new categoria();
				$elemento->set_idcategoria($this->db->f($this->categoria_relN_field));
				$elemento->load();
				$this->categoria_collection[] = $elemento;
			}
			return true;
		}
		function get_categoria_collection()
		{
			$this->load_categoria_collection();
			return $this->categoria_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one tipoacompanamiento using a collection element (parent)
		
		
		function load_tipoacompanamiento_by_categoria_inverse($idcategoria)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->categoria_rel_table WHERE $idcategoria = $this->categoria_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new tipoacompanamiento();
				$elemento->set_idtipoacompanamiento ($this->db->f($this->idtipoacompanamiento_field));
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
			
			$dbQuery = "INSERT INTO $this->tipoacompanamiento_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idtipoacompanamiento = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->tipoacompanamiento_table WHERE $this->idtipoacompanamiento_field = $this->idtipoacompanamiento ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->tipoacompanamiento_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idtipoacompanamiento_field = $this->idtipoacompanamiento ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_categoria ($idcategoria)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->categoria_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idtipoacompanamiento_field,";
		   	$dbQuery .= " $this->categoria_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idtipoacompanamiento,";
		   	$dbQuery .= " $idcategoria";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_categoria ($idcategoria)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->categoria_rel_table ";
			$dbQuery.= " WHERE $this->idtipoacompanamiento_field = $this->idtipoacompanamiento ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->categoria_relN_field = $idcategoria ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idtipoacompanamiento()
		{
			return $this->idtipoacompanamiento;
		}
 		function set_idtipoacompanamiento($id)
		{
			$this->idtipoacompanamiento=$id;
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
		
		//elements
		
 	}
 ?>
 