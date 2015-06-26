 
 <?php
 	
	require_once("actividad.php");
	require_once("seccion.php");
 	
 	class curso 
 	{
 		//database
 		var $db;
 		//id
 		var $idcurso;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $codigo; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		var $actividad_collection = array();
		var $seccion_collection = array();
		
		//elements
		
		
		//table name
		var $curso_table="curso";
		
		//id field
		var $idcurso_field = "idcurso";
		
		//field names
		
		var $nombre_field="nombre";
		var $codigo_field="codigo";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// actividad : 1-N relation
		//var $actividad_table = "actividad";
		var $actividad_relN_field = "idactividad";
		var $actividad_rel_table = "curso_has_actividad";
		// seccion : 1-N relation
		//var $seccion_table = "seccion";
		var $seccion_relN_field = "idseccion";
		var $seccion_rel_table = "curso_has_seccion";
		
		//constructor
		function curso( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idcurso = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->curso_table." WHERE ".$this->idcurso_field." = ".$this->idcurso;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->codigo = $this->db->f($this->codigo_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_actividad_collection()
		{
			$this->actividad_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->actividad_rel_table WHERE $this->idcurso = $this->idcurso_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new actividad();
				$elemento->set_idactividad($this->db->f($this->actividad_relN_field));
				$elemento->load();
				$this->actividad_collection[] = $elemento;
			}
			return true;
		}
		function get_actividad_collection()
		{
			$this->load_actividad_collection();
			return $this->actividad_collection;
		}
		
		function load_seccion_collection()
		{
			$this->seccion_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->seccion_rel_table WHERE $this->idcurso = $this->idcurso_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new seccion();
				$elemento->set_idseccion($this->db->f($this->seccion_relN_field));
				$elemento->load();
				$this->seccion_collection[] = $elemento;
			}
			return true;
		}
		function get_seccion_collection()
		{
			$this->load_seccion_collection();
			return $this->seccion_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one curso using a collection element (parent)
		
		
		function load_curso_by_actividad_inverse($idactividad)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->actividad_rel_table WHERE $idactividad = $this->actividad_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
				$elemento->load();
				return $elemento;
			}
			return false;
		}
		
		
		function load_curso_by_seccion_inverse($idseccion)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->seccion_rel_table WHERE $idseccion = $this->seccion_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
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
			
			$dbQuery = "INSERT INTO $this->curso_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->codigo_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->codigo',";
			$dbQuery .= " '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idcurso = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->curso_table WHERE $this->idcurso_field = $this->idcurso ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->curso_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->codigo_field = '$this->codigo',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idcurso_field = $this->idcurso ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_actividad ($idactividad)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->actividad_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso_field,";
		   	$dbQuery .= " $this->actividad_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso,";
		   	$dbQuery .= " $idactividad";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_seccion ($idseccion)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->seccion_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso_field,";
		   	$dbQuery .= " $this->seccion_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso,";
		   	$dbQuery .= " $idseccion";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_actividad ($idactividad)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->actividad_rel_table ";
			$dbQuery.= " WHERE $this->idcurso_field = $this->idcurso ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->actividad_relN_field = $idactividad ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_seccion ($idseccion)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->seccion_rel_table ";
			$dbQuery.= " WHERE $this->idcurso_field = $this->idcurso ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->seccion_relN_field = $idseccion ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idcurso()
		{
			return $this->idcurso;
		}
 		function set_idcurso($id)
		{
			$this->idcurso=$id;
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
		
		function get_codigo()
		{
			return $this->codigo;
		}
		function set_codigo($value)
		{
			$this->codigo = $value;
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
 