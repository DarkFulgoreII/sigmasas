 
 <?php
 	
	require_once("aspecto.php");
 	
 	class categoria 
 	{
 		//database
 		var $db;
 		//id
 		var $idcategoria;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		var $orden; // (int)
		var $multiple; // (tinyint)
		
		//collections
		
		var $aspecto_collection = array();
		
		//elements
		
		
		//table name
		var $categoria_table="categoria";
		
		//id field
		var $idcategoria_field = "idcategoria";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		var $orden_field="orden";
		var $multiple_field="multiple";
		
		//relation table names
		
		// aspecto : 1-N relation
		//var $aspecto_table = "aspecto";
		var $aspecto_relN_field = "idaspecto";
		var $aspecto_rel_table = "categoria_has_aspecto";
		
		//constructor
		function categoria( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idcategoria = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->categoria_table." WHERE ".$this->idcategoria_field." = ".$this->idcategoria;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->orden = $this->db->f($this->orden_field);
				$this->multiple = $this->db->f($this->multiple_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_aspecto_collection()
		{
			$this->aspecto_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->aspecto_rel_table WHERE $this->idcategoria = $this->idcategoria_field";
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
		
		//LOAD RELATIONS -N (INVERSE) load one categoria using a collection element (parent)
		
		
		function load_categoria_by_aspecto_inverse($idaspecto)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->aspecto_rel_table WHERE $idaspecto = $this->aspecto_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new categoria();
				$elemento->set_idcategoria ($this->db->f($this->idcategoria_field));
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
			
			$dbQuery = "INSERT INTO $this->categoria_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->orden_field.",";
			$dbQuery .= $this->multiple_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->orden ,";
			if($this->multiple == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idcategoria = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->categoria_table WHERE $this->idcategoria_field = $this->idcategoria ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->categoria_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->orden_field =  $this->orden ,";
			$dbQuery .= "$this->multiple_field = ";
			if($this->multiple == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idcategoria_field = $this->idcategoria ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_aspecto ($idaspecto)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->aspecto_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcategoria_field,";
		   	$dbQuery .= " $this->aspecto_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idcategoria,";
		   	$dbQuery .= " $idaspecto";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_aspecto ($idaspecto)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->aspecto_rel_table ";
			$dbQuery.= " WHERE $this->idcategoria_field = $this->idcategoria ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->aspecto_relN_field = $idaspecto ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idcategoria()
		{
			return $this->idcategoria;
		}
 		function set_idcategoria($id)
		{
			$this->idcategoria=$id;
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
		
		function get_orden()
		{
			return $this->orden;
		}
		function set_orden($value)
		{
			$this->orden = $value;
		}
		
		function get_multiple()
		{
			return $this->multiple;
		}
		function set_multiple($value)
		{
			$this->multiple = $value;
		}
		
		//elements
		
 	}
 ?>
 