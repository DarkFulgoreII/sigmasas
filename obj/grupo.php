 
 <?php
 	
	require_once("estudiante.php");
 	
 	class grupo 
 	{
 		//database
 		var $db;
 		//id
 		var $idgrupo;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		
		//collections
		
		var $estudiante_collection = array();
		
		//elements
		
		
		//table name
		var $grupo_table="grupo";
		
		//id field
		var $idgrupo_field = "idgrupo";
		
		//field names
		
		var $nombre_field="nombre";
		
		//relation table names
		
		// estudiante : 1-N relation
		//var $estudiante_table = "estudiante";
		var $estudiante_relN_field = "idestudiante";
		var $estudiante_rel_table = "grupo_has_estudiante";
		
		//constructor
		function grupo( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idgrupo = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->grupo_table." WHERE ".$this->idgrupo_field." = ".$this->idgrupo;
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
		
		function load_estudiante_collection()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $this->idgrupo = $this->idgrupo_field";
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
		
		//LOAD RELATIONS -N (INVERSE) load one grupo using a collection element (parent)
		
		
		function load_grupo_by_estudiante_inverse($idestudiante)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $idestudiante = $this->estudiante_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new grupo();
				$elemento->set_idgrupo ($this->db->f($this->idgrupo_field));
				$elemento->load();
				return $elemento;
			}
			return false;
		}
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->grupo_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idgrupo = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->grupo_table WHERE $this->idgrupo_field = $this->idgrupo ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->grupo_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idgrupo_field = $this->idgrupo ";
			
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
		   	$dbQuery .= " $this->idgrupo_field,";
		   	$dbQuery .= " $this->estudiante_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idgrupo,";
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
			$dbQuery.= " WHERE $this->idgrupo_field = $this->idgrupo ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->estudiante_relN_field = $idestudiante ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idgrupo()
		{
			return $this->idgrupo;
		}
 		function set_idgrupo($id)
		{
			$this->idgrupo=$id;
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
 