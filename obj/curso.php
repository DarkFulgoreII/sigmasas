 
 <?php
 	
	require_once("actividad.php");
	require_once("seccion.php");
	require_once("competencia.php");
	require_once("rubrica.php");
 	
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
		var $competencia_collection = array();
		var $rubrica_collection = array();
		
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
		// competencia : 1-N relation
		//var $competencia_table = "competencia";
		var $competencia_relN_field = "idcompetencia";
		var $competencia_rel_table = "curso_has_competencia";
		// rubrica : 1-N relation
		//var $rubrica_table = "rubrica";
		var $rubrica_relN_field = "idrubrica";
		var $rubrica_rel_table = "curso_has_rubrica";
		
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
		
		function load_competencia_collection()
		{
			$this->competencia_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->competencia_rel_table WHERE $this->idcurso = $this->idcurso_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new competencia();
				$elemento->set_idcompetencia($this->db->f($this->competencia_relN_field));
				$elemento->load();
				$this->competencia_collection[] = $elemento;
			}
			return true;
		}
		function get_competencia_collection()
		{
			$this->load_competencia_collection();
			return $this->competencia_collection;
		}
		
		function load_rubrica_collection()
		{
			$this->rubrica_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rubrica_rel_table WHERE $this->idcurso = $this->idcurso_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new rubrica();
				$elemento->set_idrubrica($this->db->f($this->rubrica_relN_field));
				$elemento->load();
				$this->rubrica_collection[] = $elemento;
			}
			return true;
		}
		function get_rubrica_collection()
		{
			$this->load_rubrica_collection();
			return $this->rubrica_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one curso using a collection element (parent)
		
		
		function load_curso_by_actividad_inverse($idactividad)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->actividad_rel_table WHERE $idactividad = $this->actividad_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_curso_by_seccion_inverse($idseccion)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->seccion_rel_table WHERE $idseccion = $this->seccion_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_curso_by_competencia_inverse($idcompetencia)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->competencia_rel_table WHERE $idcompetencia = $this->competencia_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_curso_by_rubrica_inverse($idrubrica)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rubrica_rel_table WHERE $idrubrica = $this->rubrica_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso ($this->db->f($this->idcurso_field));
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
		
		function add_competencia ($idcompetencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->competencia_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso_field,";
		   	$dbQuery .= " $this->competencia_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso,";
		   	$dbQuery .= " $idcompetencia";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_rubrica ($idrubrica)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->rubrica_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso_field,";
		   	$dbQuery .= " $this->rubrica_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcurso,";
		   	$dbQuery .= " $idrubrica";
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
		
		function remove_competencia ($idcompetencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->competencia_rel_table ";
			$dbQuery.= " WHERE $this->idcurso_field = $this->idcurso ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->competencia_relN_field = $idcompetencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_rubrica ($idrubrica)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->rubrica_rel_table ";
			$dbQuery.= " WHERE $this->idcurso_field = $this->idcurso ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->rubrica_relN_field = $idrubrica ";
			
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
 