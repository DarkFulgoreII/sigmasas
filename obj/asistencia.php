 
 <?php
 	
	require_once("seccion.php");
	require_once("bloque.php");
 	
 	class asistencia 
 	{
 		//database
 		var $db;
 		//id
 		var $idasistencia;
 		
		//simple attributes
		
		var $asiste;
		var $registradapor;
		var $fecha;
		var $justificacion;
		var $observaciones;
		
		//collections
		
		
		//elements
		
		var $seccion_element ;
		var $bloque_element ;
		
		//table name
		var $asistencia_table="asistencia";
		
		//id field
		var $idasistencia_field = "idasistencia";
		
		//field names
		
		var $asiste_field="asiste";
		var $registradapor_field="registradapor";
		var $fecha_field="fecha";
		var $justificacion_field="justificacion";
		var $observaciones_field="observaciones";
		
		//relation table names
		
		// seccion : 1-1 relation
		//var $seccion_table = "seccion";
		var $seccion_rel1_field = "idseccion";
		
		// bloque : 1-1 relation
		//var $bloque_table = "bloque";
		var $bloque_rel1_field = "idbloque";
		
		
		//constructor
		function asistencia( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idasistencia = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->asistencia_table." WHERE ".$this->idasistencia_field." = ".$this->idasistencia;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->asiste = $this->db->f($this->asiste_field);
				$this->registradapor = $this->db->f($this->registradapor_field);
				$this->fecha = $this->db->f($this->fecha_field);
				$this->justificacion = $this->db->f($this->justificacion_field);
				$this->observaciones = $this->db->f($this->observaciones_field);
				//elements
				
				$this->seccion_element = $this->db->f($this->seccion_rel1_field);
				$this->bloque_element = $this->db->f($this->bloque_rel1_field);
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		//LOAD RELATIONS -N (INVERSE) load one asistencia using a collection element (parent)
		
		
		
		
		//LOAD RELATIONS - 1
		
		function get_seccion_element()
		{
			$element = new seccion();
			$element ->set_idseccion( $this->seccion_element );
			$element->load();
			return $element;
		}
		
		function get_bloque_element()
		{
			$element = new bloque();
			$element ->set_idbloque( $this->bloque_element );
			$element->load();
			return $element;
		}
		
		//INSERT
		function insert ()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->asistencia_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->asiste_field.",";
			$dbQuery .= $this->registradapor_field.",";
			$dbQuery .= $this->fecha_field.",";
			$dbQuery .= $this->justificacion_field.",";
			$dbQuery .= $this->observaciones_field.",";
			
			$dbQuery .= "$this->seccion_rel1_field,";
			$dbQuery .= "$this->bloque_rel1_field,";
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			if($this->asiste == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= " '$this->registradapor',";
			$dbQuery .= " '$this->fecha',";
			if($this->justificacion == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= " '$this->observaciones',";
			
			$dbQuery .= "$this->seccion_element,";
			$dbQuery .= "$this->bloque_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idasistencia = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->asistencia_table WHERE $this->idasistencia_field = $this->idasistencia ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->asistencia_table SET ";
			
			
			
			$dbQuery .= "$this->asiste_field = ";
			if($this->asiste == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "$this->registradapor_field = '$this->registradapor',";
			$dbQuery .= "$this->fecha_field = '$this->fecha',";
			$dbQuery .= "$this->justificacion_field = ";
			if($this->justificacion == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "$this->observaciones_field = '$this->observaciones',";
			
			$dbQuery .= "$this->seccion_rel1_field = $this->seccion_element,";
			$dbQuery .= "$this->bloque_rel1_field = $this->bloque_element,";
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idasistencia_field = $this->idasistencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		//REMOVE FROM COLLECTION
		
		
		//GETTERS AND SETTERS
		
		function get_idasistencia()
		{
			return $this->idasistencia;
		}
 		function set_idasistencia($id)
		{
			$this->idasistencia=$id;
		}		
		//simple attributes
		
		function get_asiste()
		{
			return $this->asiste;
		}
		function set_asiste($value)
		{
			$this->asiste = $value;
		}
		
		function get_registradapor()
		{
			return $this->registradapor;
		}
		function set_registradapor($value)
		{
			$this->registradapor = $value;
		}
		
		function get_fecha()
		{
			return $this->fecha;
		}
		function set_fecha($value)
		{
			$this->fecha = $value;
		}
		
		function get_justificacion()
		{
			return $this->justificacion;
		}
		function set_justificacion($value)
		{
			$this->justificacion = $value;
		}
		
		function get_observaciones()
		{
			return $this->observaciones;
		}
		function set_observaciones($value)
		{
			$this->observaciones = $value;
		}
		
		//elements
		
		function set_seccion_element($object)
		{	
			//update the foreign id based on the object
			$this->seccion_element = $object->get_idseccion();
		}
		
		function set_bloque_element($object)
		{	
			//update the foreign id based on the object
			$this->bloque_element = $object->get_idbloque();
		}
		
 	}
 ?>
 