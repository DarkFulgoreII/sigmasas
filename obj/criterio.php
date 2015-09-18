 
 <?php
 	
	require_once("competencia.php");
	require_once("escala.php");
 	
 	class criterio 
 	{
 		//database
 		var $db;
 		//id
 		var $idcriterio;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		var $puntajeMaximo; // (float)
		
		//collections
		
		var $competencia_collection = array();
		var $escala_collection = array();
		
		//elements
		
		
		//table name
		var $criterio_table="criterio";
		
		//id field
		var $idcriterio_field = "idcriterio";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		var $puntajeMaximo_field="puntajeMaximo";
		
		//relation table names
		
		// competencia : 1-N relation
		//var $competencia_table = "competencia";
		var $competencia_relN_field = "idcompetencia";
		var $competencia_rel_table = "criterio_has_competencia";
		// escala : 1-N relation
		//var $escala_table = "escala";
		var $escala_relN_field = "idescala";
		var $escala_rel_table = "criterio_has_escala";
		
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
				$this->puntajeMaximo = $this->db->f($this->puntajeMaximo_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_competencia_collection()
		{
			$this->competencia_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->competencia_rel_table WHERE $this->idcriterio = $this->idcriterio_field";
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
		
		function load_escala_collection()
		{
			$this->escala_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->escala_rel_table WHERE $this->idcriterio = $this->idcriterio_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new escala();
				$elemento->set_idescala($this->db->f($this->escala_relN_field));
				$elemento->load();
				$this->escala_collection[] = $elemento;
			}
			return true;
		}
		function get_escala_collection()
		{
			$this->load_escala_collection();
			return $this->escala_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one criterio using a collection element (parent)
		
		
		function load_criterio_by_competencia_inverse($idcompetencia)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->competencia_rel_table WHERE $idcompetencia = $this->competencia_relN_field";
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
		
		
		function load_criterio_by_escala_inverse($idescala)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->escala_rel_table WHERE $idescala = $this->escala_relN_field";
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
			$dbQuery .= $this->puntajeMaximo_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->puntajeMaximo ,";
			
		   	
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
			$dbQuery .= "$this->puntajeMaximo_field =  $this->puntajeMaximo ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idcriterio_field = $this->idcriterio ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_competencia ($idcompetencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->competencia_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio_field,";
		   	$dbQuery .= " $this->competencia_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio,";
		   	$dbQuery .= " $idcompetencia";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_escala ($idescala)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->escala_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio_field,";
		   	$dbQuery .= " $this->escala_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcriterio,";
		   	$dbQuery .= " $idescala";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_competencia ($idcompetencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->competencia_rel_table ";
			$dbQuery.= " WHERE $this->idcriterio_field = $this->idcriterio ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->competencia_relN_field = $idcompetencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_escala ($idescala)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->escala_rel_table ";
			$dbQuery.= " WHERE $this->idcriterio_field = $this->idcriterio ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->escala_relN_field = $idescala ";
			
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
		
		function get_puntajeMaximo()
		{
			return $this->puntajeMaximo;
		}
		function set_puntajeMaximo($value)
		{
			$this->puntajeMaximo = $value;
		}
		
		//elements
		
 	}
 ?>
 