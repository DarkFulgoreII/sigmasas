 
 <?php
 	
	require_once("compentencia.php");
 	
 	class criterio 
 	{
 		//database
 		var $db;
 		//id
 		var $idcriterio;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		var $compentencia_collection = array();
		
		//elements
		
		
		//table name
		var $criterio_table="criterio";
		
		//id field
		var $idcriterio_field = "idcriterio";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// compentencia : 1-N relation
		//var $compentencia_table = "compentencia";
		var $compentencia_relN_field = "idcompentencia";
		var $compentencia_rel_table = "criterio_has_compentencia";
		
		//constructor
		function criterio( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idcriterio = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->criterio_table." WHERE ".$this->idcriterio_field." = ".$this->idcriterio;
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
		
		function load_compentencia_collection()
		{
			$this->compentencia_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->compentencia_rel_table WHERE $this->idcriterio = $this->idcriterio_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new compentencia();
				$elemento->set_idcompentencia($this->db->f($this->compentencia_relN_field));
				$elemento->load();
				$this->compentencia_collection[] = $elemento;
			}
			return true;
		}
		function get_compentencia_collection()
		{
			$this->load_compentencia_collection();
			return $this->compentencia_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one criterio using a collection element (parent)
		
		
		function load_criterio_by_compentencia_inverse($idcompentencia)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->compentencia_rel_table WHERE $idcompentencia = $this->compentencia_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new criterio();
				$elemento->set_idcriterio ($this->db->f($this->idcriterio_field));
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
			
			$dbQuery = "INSERT INTO $this->criterio_table ";
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
			
			$this->idcriterio = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->criterio_table WHERE $this->idcriterio_field = $this->idcriterio ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->criterio_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idcriterio_field = $this->idcriterio ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_compentencia ($idcompentencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->compentencia_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio_field,";
		   	$dbQuery .= " $this->compentencia_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio,";
		   	$dbQuery .= " $idcompentencia";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_compentencia ($idcompentencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->compentencia_rel_table ";
			$dbQuery.= " WHERE $this->idcriterio_field = $this->idcriterio ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->compentencia_relN_field = $idcompentencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idcriterio()
		{
			return $this->idcriterio;
		}
 		function set_idcriterio($id)
		{
			$this->idcriterio=$id;
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
 