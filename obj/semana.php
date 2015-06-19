 
 <?php
 	
 	
 	class semana 
 	{
 		//database
 		var $db;
 		//id
 		var $idsemana;
 		
		//simple attributes
		
		var $fechainicial; // (date)
		var $fechafinal; // (date)
		var $cohorte; // (int)
		var $numerosemana; // (int)
		var $descripcion; // (varchar)
		
		//collections
		
		
		//elements
		
		
		//table name
		var $semana_table="semana";
		
		//id field
		var $idsemana_field = "idsemana";
		
		//field names
		
		var $fechainicial_field="fechainicial";
		var $fechafinal_field="fechafinal";
		var $cohorte_field="cohorte";
		var $numerosemana_field="numerosemana";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		
		//constructor
		function semana( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idsemana = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->semana_table." WHERE ".$this->idsemana_field." = ".$this->idsemana;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->fechainicial = $this->db->f($this->fechainicial_field);
				$this->fechafinal = $this->db->f($this->fechafinal_field);
				$this->cohorte = $this->db->f($this->cohorte_field);
				$this->numerosemana = $this->db->f($this->numerosemana_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one semana using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->semana_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->fechainicial_field.",";
			$dbQuery .= $this->fechafinal_field.",";
			$dbQuery .= $this->cohorte_field.",";
			$dbQuery .= $this->numerosemana_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->fechainicial',";
			$dbQuery .= " '$this->fechafinal',";
			$dbQuery .= "  $this->cohorte ,";
			$dbQuery .= "  $this->numerosemana ,";
			$dbQuery .= " '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idsemana = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->semana_table WHERE $this->idsemana_field = $this->idsemana ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->semana_table SET ";
			
			
			
			$dbQuery .= "$this->fechainicial_field = '$this->fechainicial',";
			$dbQuery .= "$this->fechafinal_field = '$this->fechafinal',";
			$dbQuery .= "$this->cohorte_field =  $this->cohorte ,";
			$dbQuery .= "$this->numerosemana_field =  $this->numerosemana ,";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idsemana_field = $this->idsemana ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idsemana()
		{
			return $this->idsemana;
		}
 		function set_idsemana($id)
		{
			$this->idsemana=$id;
		}		
		//simple attributes
		
		function get_fechainicial()
		{
			return $this->fechainicial;
		}
		function set_fechainicial($value)
		{
			$this->fechainicial = $value;
		}
		
		function get_fechafinal()
		{
			return $this->fechafinal;
		}
		function set_fechafinal($value)
		{
			$this->fechafinal = $value;
		}
		
		function get_cohorte()
		{
			return $this->cohorte;
		}
		function set_cohorte($value)
		{
			$this->cohorte = $value;
		}
		
		function get_numerosemana()
		{
			return $this->numerosemana;
		}
		function set_numerosemana($value)
		{
			$this->numerosemana = $value;
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
 