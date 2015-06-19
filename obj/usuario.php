 
 <?php
 	
	require_once("rol.php");
 	
 	class usuario 
 	{
 		//database
 		var $db;
 		//id
 		var $idusuario;
 		
		//simple attributes
		
		var $login; // (varchar)
		var $nombres; // (varchar)
		
		//collections
		
		var $rol_collection = array();
		
		//elements
		
		
		//table name
		var $usuario_table="usuario";
		
		//id field
		var $idusuario_field = "idusuario";
		
		//field names
		
		var $login_field="login";
		var $nombres_field="nombres";
		
		//relation table names
		
		// rol : 1-N relation
		//var $rol_table = "rol";
		var $rol_relN_field = "idrol";
		var $rol_rel_table = "usuario_has_rol";
		
		//constructor
		function usuario( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idusuario = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->usuario_table." WHERE ".$this->idusuario_field." = ".$this->idusuario;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->login = $this->db->f($this->login_field);
				$this->nombres = $this->db->f($this->nombres_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_rol_collection()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rol_rel_table WHERE $this->idusuario = $this->idusuario_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new rol();
				$elemento->set_idrol($this->db->f($this->rol_relN_field));
				$elemento->load();
				$this->rol_collection[] = $elemento;
			}
			return true;
		}
		function get_rol_collection()
		{
			$this->load_rol_collection();
			return $this->rol_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one usuario using a collection element (parent)
		
		
		function load_usuario_by_rol_inverse($idrol)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rol_rel_table WHERE $idrol = $this->rol_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new usuario();
				$elemento->set_idusuario ($this->db->f($this->idusuario_field));
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
			
			$dbQuery = "INSERT INTO $this->usuario_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->login_field.",";
			$dbQuery .= $this->nombres_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->login',";
			$dbQuery .= " '$this->nombres',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idusuario = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->usuario_table WHERE $this->idusuario_field = $this->idusuario ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->usuario_table SET ";
			
			
			
			$dbQuery .= "$this->login_field = '$this->login',";
			$dbQuery .= "$this->nombres_field = '$this->nombres',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idusuario_field = $this->idusuario ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_rol ($idrol)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->rol_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idusuario_field,";
		   	$dbQuery .= " $this->rol_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idusuario,";
		   	$dbQuery .= " $idrol";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_rol ($idrol)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->rol_rel_table ";
			$dbQuery.= " WHERE $this->idusuario_field = $this->idusuario ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->rol_relN_field = $idrol ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idusuario()
		{
			return $this->idusuario;
		}
 		function set_idusuario($id)
		{
			$this->idusuario=$id;
		}		
		//simple attributes
		
		function get_login()
		{
			return $this->login;
		}
		function set_login($value)
		{
			$this->login = $value;
		}
		
		function get_nombres()
		{
			return $this->nombres;
		}
		function set_nombres($value)
		{
			$this->nombres = $value;
		}
		
		//elements
		
 	}
 ?>
 