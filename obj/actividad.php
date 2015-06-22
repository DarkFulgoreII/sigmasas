 
 <?php
 	
 	
 	class actividad 
 	{
 		//database
 		var $db;
 		//id
 		var $idactividad;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $descripcion; // (varchar)
		var $numerosemana; // (int)
		var $tipo; // (varchar)
		var $calificable; // (tinyint)
		var $peso; // (float)
		
		//collections
		
		
		//elements
		
		
		//table name
		var $actividad_table="actividad";
		
		//id field
		var $idactividad_field = "idactividad";
		
		//field names
		
		var $nombre_field="nombre";
		var $descripcion_field="descripcion";
		var $numerosemana_field="numerosemana";
		var $tipo_field="tipo";
		var $calificable_field="calificable";
		var $peso_field="peso";
		
		//relation table names
		
		
		//constructor
		function actividad( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idactividad = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->actividad_table." WHERE ".$this->idactividad_field." = ".$this->idactividad;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				$this->numerosemana = $this->db->f($this->numerosemana_field);
				$this->tipo = $this->db->f($this->tipo_field);
				$this->calificable = $this->db->f($this->calificable_field);
				$this->peso = $this->db->f($this->peso_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one actividad using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->actividad_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			$dbQuery .= $this->numerosemana_field.",";
			$dbQuery .= $this->tipo_field.",";
			$dbQuery .= $this->calificable_field.",";
			$dbQuery .= $this->peso_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->descripcion',";
			$dbQuery .= "  $this->numerosemana ,";
			$dbQuery .= " '$this->tipo',";
			if($this->calificable == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "  $this->peso ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idactividad = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->actividad_table WHERE $this->idactividad_field = $this->idactividad ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->actividad_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			$dbQuery .= "$this->numerosemana_field =  $this->numerosemana ,";
			$dbQuery .= "$this->tipo_field = '$this->tipo',";
			$dbQuery .= "$this->calificable_field = ";
			if($this->calificable == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "$this->peso_field =  $this->peso ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idactividad_field = $this->idactividad ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idactividad()
		{
			return $this->idactividad;
		}
 		function set_idactividad($id)
		{
			$this->idactividad=$id;
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
		
		function get_numerosemana()
		{
			return $this->numerosemana;
		}
		function set_numerosemana($value)
		{
			$this->numerosemana = $value;
		}
		
		function get_tipo()
		{
			return $this->tipo;
		}
		function set_tipo($value)
		{
			$this->tipo = $value;
		}
		
		function get_calificable()
		{
			return $this->calificable;
		}
		function set_calificable($value)
		{
			$this->calificable = $value;
		}
		
		function get_peso()
		{
			return $this->peso;
		}
		function set_peso($value)
		{
			$this->peso = $value;
		}
		
		//elements
		
 	}
 ?>
 