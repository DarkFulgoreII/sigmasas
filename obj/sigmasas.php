 
 <?php
 	
	require_once("acompanamiento.php");
	require_once("curso.php");
	require_once("estudiante.php");
	require_once("grupo.php");
	require_once("rol.php");
	require_once("usuario.php");
	require_once("bloque.php");
	require_once("semana.php");
	require_once("categoria.php");
	require_once("tipoacompanamiento.php");
 	
 	class sigmasas 
 	{
 		//database
 		var $db;
 		//id
 		var $idsigmasas;
 		
		//simple attributes
		
		var $nombre; // (varchar)
		var $semestre; // (varchar)
		var $descripcion; // (varchar)
		
		//collections
		
		var $acompanamiento_collection = array();
		var $curso_collection = array();
		var $estudiante_collection = array();
		var $grupo_collection = array();
		var $rol_collection = array();
		var $usuario_collection = array();
		var $bloque_collection = array();
		var $semana_collection = array();
		var $categoria_collection = array();
		var $tipoacompanamiento_collection = array();
		
		//elements
		
		
		//table name
		var $sigmasas_table="sigmasas";
		
		//id field
		var $idsigmasas_field = "idsigmasas";
		
		//field names
		
		var $nombre_field="nombre";
		var $semestre_field="semestre";
		var $descripcion_field="descripcion";
		
		//relation table names
		
		// acompanamiento : 1-N relation
		//var $acompanamiento_table = "acompanamiento";
		var $acompanamiento_relN_field = "idacompanamiento";
		var $acompanamiento_rel_table = "sigmasas_has_acompanamiento";
		// curso : 1-N relation
		//var $curso_table = "curso";
		var $curso_relN_field = "idcurso";
		var $curso_rel_table = "sigmasas_has_curso";
		// estudiante : 1-N relation
		//var $estudiante_table = "estudiante";
		var $estudiante_relN_field = "idestudiante";
		var $estudiante_rel_table = "sigmasas_has_estudiante";
		// grupo : 1-N relation
		//var $grupo_table = "grupo";
		var $grupo_relN_field = "idgrupo";
		var $grupo_rel_table = "sigmasas_has_grupo";
		// rol : 1-N relation
		//var $rol_table = "rol";
		var $rol_relN_field = "idrol";
		var $rol_rel_table = "sigmasas_has_rol";
		// usuario : 1-N relation
		//var $usuario_table = "usuario";
		var $usuario_relN_field = "idusuario";
		var $usuario_rel_table = "sigmasas_has_usuario";
		// bloque : 1-N relation
		//var $bloque_table = "bloque";
		var $bloque_relN_field = "idbloque";
		var $bloque_rel_table = "sigmasas_has_bloque";
		// semana : 1-N relation
		//var $semana_table = "semana";
		var $semana_relN_field = "idsemana";
		var $semana_rel_table = "sigmasas_has_semana";
		// categoria : 1-N relation
		//var $categoria_table = "categoria";
		var $categoria_relN_field = "idcategoria";
		var $categoria_rel_table = "sigmasas_has_categoria";
		// tipoacompanamiento : 1-N relation
		//var $tipoacompanamiento_table = "tipoacompanamiento";
		var $tipoacompanamiento_relN_field = "idtipoacompanamiento";
		var $tipoacompanamiento_rel_table = "sigmasas_has_tipoacompanamiento";
		
		//constructor
		function sigmasas( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idsigmasas = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->sigmasas_table." WHERE ".$this->idsigmasas_field." = ".$this->idsigmasas;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombre = $this->db->f($this->nombre_field);
				$this->semestre = $this->db->f($this->semestre_field);
				$this->descripcion = $this->db->f($this->descripcion_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_acompanamiento_collection()
		{
			$this->acompanamiento_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->acompanamiento_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new acompanamiento();
				$elemento->set_idacompanamiento($this->db->f($this->acompanamiento_relN_field));
				$elemento->load();
				$this->acompanamiento_collection[] = $elemento;
			}
			return true;
		}
		function get_acompanamiento_collection()
		{
			$this->load_acompanamiento_collection();
			return $this->acompanamiento_collection;
		}
		
		function load_curso_collection()
		{
			$this->curso_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->curso_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new curso();
				$elemento->set_idcurso($this->db->f($this->curso_relN_field));
				$elemento->load();
				$this->curso_collection[] = $elemento;
			}
			return true;
		}
		function get_curso_collection()
		{
			$this->load_curso_collection();
			return $this->curso_collection;
		}
		
		function load_estudiante_collection()
		{
			$this->estudiante_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
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
		
		function load_grupo_collection()
		{
			$this->grupo_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->grupo_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new grupo();
				$elemento->set_idgrupo($this->db->f($this->grupo_relN_field));
				$elemento->load();
				$this->grupo_collection[] = $elemento;
			}
			return true;
		}
		function get_grupo_collection()
		{
			$this->load_grupo_collection();
			return $this->grupo_collection;
		}
		
		function load_rol_collection()
		{
			$this->rol_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rol_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
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
		
		function load_usuario_collection()
		{
			$this->usuario_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->usuario_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new usuario();
				$elemento->set_idusuario($this->db->f($this->usuario_relN_field));
				$elemento->load();
				$this->usuario_collection[] = $elemento;
			}
			return true;
		}
		function get_usuario_collection()
		{
			$this->load_usuario_collection();
			return $this->usuario_collection;
		}
		
		function load_bloque_collection()
		{
			$this->bloque_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->bloque_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new bloque();
				$elemento->set_idbloque($this->db->f($this->bloque_relN_field));
				$elemento->load();
				$this->bloque_collection[] = $elemento;
			}
			return true;
		}
		function get_bloque_collection()
		{
			$this->load_bloque_collection();
			return $this->bloque_collection;
		}
		
		function load_semana_collection()
		{
			$this->semana_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->semana_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new semana();
				$elemento->set_idsemana($this->db->f($this->semana_relN_field));
				$elemento->load();
				$this->semana_collection[] = $elemento;
			}
			return true;
		}
		function get_semana_collection()
		{
			$this->load_semana_collection();
			return $this->semana_collection;
		}
		
		function load_categoria_collection()
		{
			$this->categoria_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->categoria_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new categoria();
				$elemento->set_idcategoria($this->db->f($this->categoria_relN_field));
				$elemento->load();
				$this->categoria_collection[] = $elemento;
			}
			return true;
		}
		function get_categoria_collection()
		{
			$this->load_categoria_collection();
			return $this->categoria_collection;
		}
		
		function load_tipoacompanamiento_collection()
		{
			$this->tipoacompanamiento_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->tipoacompanamiento_rel_table WHERE $this->idsigmasas = $this->idsigmasas_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new tipoacompanamiento();
				$elemento->set_idtipoacompanamiento($this->db->f($this->tipoacompanamiento_relN_field));
				$elemento->load();
				$this->tipoacompanamiento_collection[] = $elemento;
			}
			return true;
		}
		function get_tipoacompanamiento_collection()
		{
			$this->load_tipoacompanamiento_collection();
			return $this->tipoacompanamiento_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one sigmasas using a collection element (parent)
		
		
		function load_sigmasas_by_acompanamiento_inverse($idacompanamiento)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->acompanamiento_rel_table WHERE $idacompanamiento = $this->acompanamiento_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_curso_inverse($idcurso)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->curso_rel_table WHERE $idcurso = $this->curso_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_estudiante_inverse($idestudiante)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->estudiante_rel_table WHERE $idestudiante = $this->estudiante_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_grupo_inverse($idgrupo)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->grupo_rel_table WHERE $idgrupo = $this->grupo_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_rol_inverse($idrol)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->rol_rel_table WHERE $idrol = $this->rol_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_usuario_inverse($idusuario)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->usuario_rel_table WHERE $idusuario = $this->usuario_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_bloque_inverse($idbloque)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->bloque_rel_table WHERE $idbloque = $this->bloque_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_semana_inverse($idsemana)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->semana_rel_table WHERE $idsemana = $this->semana_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_categoria_inverse($idcategoria)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->categoria_rel_table WHERE $idcategoria = $this->categoria_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
				$elemento->load();
				$result[] = $elemento;
			}
			return $result;
		}
		
		
		function load_sigmasas_by_tipoacompanamiento_inverse($idtipoacompanamiento)
		{
			$result = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->tipoacompanamiento_rel_table WHERE $idtipoacompanamiento = $this->tipoacompanamiento_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new sigmasas();
				$elemento->set_idsigmasas ($this->db->f($this->idsigmasas_field));
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
			
			$dbQuery = "INSERT INTO $this->sigmasas_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombre_field.",";
			$dbQuery .= $this->semestre_field.",";
			$dbQuery .= $this->descripcion_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombre',";
			$dbQuery .= " '$this->semestre',";
			$dbQuery .= " '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idsigmasas = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->sigmasas_table WHERE $this->idsigmasas_field = $this->idsigmasas ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->sigmasas_table SET ";
			
			
			
			$dbQuery .= "$this->nombre_field = '$this->nombre',";
			$dbQuery .= "$this->semestre_field = '$this->semestre',";
			$dbQuery .= "$this->descripcion_field = '$this->descripcion',";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_acompanamiento ($idacompanamiento)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->acompanamiento_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->acompanamiento_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idacompanamiento";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_curso ($idcurso)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->curso_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->curso_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idcurso";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_estudiante ($idestudiante)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->estudiante_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->estudiante_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idestudiante";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_grupo ($idgrupo)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->grupo_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->grupo_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idgrupo";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_rol ($idrol)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->rol_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->rol_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idrol";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_usuario ($idusuario)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->usuario_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->usuario_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idusuario";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_bloque ($idbloque)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->bloque_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->bloque_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idbloque";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_semana ($idsemana)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->semana_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->semana_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idsemana";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_categoria ($idcategoria)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->categoria_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->categoria_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idcategoria";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_tipoacompanamiento ($idtipoacompanamiento)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->tipoacompanamiento_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas_field,";
		   	$dbQuery .= " $this->tipoacompanamiento_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idsigmasas,";
		   	$dbQuery .= " $idtipoacompanamiento";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_acompanamiento ($idacompanamiento)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->acompanamiento_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->acompanamiento_relN_field = $idacompanamiento ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_curso ($idcurso)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->curso_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->curso_relN_field = $idcurso ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_estudiante ($idestudiante)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->estudiante_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->estudiante_relN_field = $idestudiante ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_grupo ($idgrupo)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->grupo_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->grupo_relN_field = $idgrupo ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_rol ($idrol)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->rol_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->rol_relN_field = $idrol ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_usuario ($idusuario)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->usuario_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->usuario_relN_field = $idusuario ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_bloque ($idbloque)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->bloque_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->bloque_relN_field = $idbloque ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_semana ($idsemana)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->semana_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->semana_relN_field = $idsemana ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_categoria ($idcategoria)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->categoria_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->categoria_relN_field = $idcategoria ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_tipoacompanamiento ($idtipoacompanamiento)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->tipoacompanamiento_rel_table ";
			$dbQuery.= " WHERE $this->idsigmasas_field = $this->idsigmasas ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->tipoacompanamiento_relN_field = $idtipoacompanamiento ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idsigmasas()
		{
			return $this->idsigmasas;
		}
 		function set_idsigmasas($id)
		{
			$this->idsigmasas=$id;
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
		
		function get_semestre()
		{
			return $this->semestre;
		}
		function set_semestre($value)
		{
			$this->semestre = $value;
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
 