 
 <?php
 	
	require_once("asistencia.php");
	require_once("entrega.php");
 	
 	class estudiante 
 	{
 		//database
 		var $db;
 		//id
 		var $idestudiante;
 		
		//simple attributes
		
		var $nombres; // (varchar)
		var $apellido1; // (varchar)
		var $apellido2; // (varchar)
		var $genero; // (varchar)
		var $estadocivil; // (varchar)
		var $fechanacimiento; // (varchar)
		var $nacionalidad; // (varchar)
		var $tipodocumento; // (varchar)
		var $numdocumento; // (varchar)
		var $etnia; // (varchar)
		var $email; // (varchar)
		var $telefonofijo; // (varchar)
		var $telefonomovil; // (varchar)
		var $ciudadresidencia; // (varchar)
		var $direccionresidencia; // (varchar)
		var $acudienteapellido1; // (varchar)
		var $acudienteapellido2; // (varchar)
		var $acudientenombres; // (varchar)
		var $acudienterelacion; // (varchar)
		var $acudientetelefonofijo; // (varchar)
		var $acudientetelefonomovil; // (varchar)
		var $acudienteciudadresidencia; // (varchar)
		var $acudientedireccionresidencia; // (varchar)
		var $institucion; // (varchar)
		var $egreso; // (varchar)
		var $saber11; // (varchar)
		var $anhosaber; // (varchar)
		var $saber11matematica; // (varchar)
		var $saber11espanol; // (varchar)
		var $estudiaactualmente; // (varchar)
		var $actualmenteestudiaotros; // (varchar)
		var $admisioncentroeducativo; // (varchar)
		var $estatrabajando; // (varchar)
		var $planescortoplazo; // (varchar)
		var $planescortoplazootros; // (varchar)
		var $interesformacion; // (varchar)
		var $interesformacionotros; // (varchar)
		var $experienciavirtuales; // (varchar)
		var $estrato; // (varchar)
		var $sisben; // (varchar)
		var $especiales; // (varchar)
		var $discapacidades; // (varchar)
		var $victima; // (varchar)
		var $desmovilizado; // (varchar)
		var $hijodesmovilizado; // (varchar)
		var $desplazado; // (varchar)
		var $internet; // (varchar)
		var $internetcalidad; // (varchar)
		var $codigouniandes; // (varchar)
		var $correouniandes; // (varchar)
		var $desactivado; // (tinyint)
		var $moodleid; // (int)
		
		//collections
		
		var $asistencia_collection = array();
		var $entrega_collection = array();
		
		//elements
		
		
		//table name
		var $estudiante_table="estudiante";
		
		//id field
		var $idestudiante_field = "idestudiante";
		
		//field names
		
		var $nombres_field="nombres";
		var $apellido1_field="apellido1";
		var $apellido2_field="apellido2";
		var $genero_field="genero";
		var $estadocivil_field="estadocivil";
		var $fechanacimiento_field="fechanacimiento";
		var $nacionalidad_field="nacionalidad";
		var $tipodocumento_field="tipodocumento";
		var $numdocumento_field="numdocumento";
		var $etnia_field="etnia";
		var $email_field="email";
		var $telefonofijo_field="telefonofijo";
		var $telefonomovil_field="telefonomovil";
		var $ciudadresidencia_field="ciudadresidencia";
		var $direccionresidencia_field="direccionresidencia";
		var $acudienteapellido1_field="acudienteapellido1";
		var $acudienteapellido2_field="acudienteapellido2";
		var $acudientenombres_field="acudientenombres";
		var $acudienterelacion_field="acudienterelacion";
		var $acudientetelefonofijo_field="acudientetelefonofijo";
		var $acudientetelefonomovil_field="acudientetelefonomovil";
		var $acudienteciudadresidencia_field="acudienteciudadresidencia";
		var $acudientedireccionresidencia_field="acudientedireccionresidencia";
		var $institucion_field="institucion";
		var $egreso_field="egreso";
		var $saber11_field="saber11";
		var $anhosaber_field="anhosaber";
		var $saber11matematica_field="saber11matematica";
		var $saber11espanol_field="saber11espanol";
		var $estudiaactualmente_field="estudiaactualmente";
		var $actualmenteestudiaotros_field="actualmenteestudiaotros";
		var $admisioncentroeducativo_field="admisioncentroeducativo";
		var $estatrabajando_field="estatrabajando";
		var $planescortoplazo_field="planescortoplazo";
		var $planescortoplazootros_field="planescortoplazootros";
		var $interesformacion_field="interesformacion";
		var $interesformacionotros_field="interesformacionotros";
		var $experienciavirtuales_field="experienciavirtuales";
		var $estrato_field="estrato";
		var $sisben_field="sisben";
		var $especiales_field="especiales";
		var $discapacidades_field="discapacidades";
		var $victima_field="victima";
		var $desmovilizado_field="desmovilizado";
		var $hijodesmovilizado_field="hijodesmovilizado";
		var $desplazado_field="desplazado";
		var $internet_field="internet";
		var $internetcalidad_field="internetcalidad";
		var $codigouniandes_field="codigouniandes";
		var $correouniandes_field="correouniandes";
		var $desactivado_field="desactivado";
		var $moodleid_field="moodleid";
		
		//relation table names
		
		// asistencia : 1-N relation
		//var $asistencia_table = "asistencia";
		var $asistencia_relN_field = "idasistencia";
		var $asistencia_rel_table = "estudiante_has_asistencia";
		// entrega : 1-N relation
		//var $entrega_table = "entrega";
		var $entrega_relN_field = "identrega";
		var $entrega_rel_table = "estudiante_has_entrega";
		
		//constructor
		function estudiante( $id=0 ) 
		{
	   		$this->db = new DB_Sql();
	   		$this->idestudiante = $id;
	   	}
	   	//LOAD
		function load()
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM ".$this->estudiante_table." WHERE ".$this->idestudiante_field." = ".$this->idestudiante;
			$this->db->query( $dbQuery );
	
			if ($this->db->next_record()) 
			{
				//basic attributes
				
				$this->nombres = $this->db->f($this->nombres_field);
				$this->apellido1 = $this->db->f($this->apellido1_field);
				$this->apellido2 = $this->db->f($this->apellido2_field);
				$this->genero = $this->db->f($this->genero_field);
				$this->estadocivil = $this->db->f($this->estadocivil_field);
				$this->fechanacimiento = $this->db->f($this->fechanacimiento_field);
				$this->nacionalidad = $this->db->f($this->nacionalidad_field);
				$this->tipodocumento = $this->db->f($this->tipodocumento_field);
				$this->numdocumento = $this->db->f($this->numdocumento_field);
				$this->etnia = $this->db->f($this->etnia_field);
				$this->email = $this->db->f($this->email_field);
				$this->telefonofijo = $this->db->f($this->telefonofijo_field);
				$this->telefonomovil = $this->db->f($this->telefonomovil_field);
				$this->ciudadresidencia = $this->db->f($this->ciudadresidencia_field);
				$this->direccionresidencia = $this->db->f($this->direccionresidencia_field);
				$this->acudienteapellido1 = $this->db->f($this->acudienteapellido1_field);
				$this->acudienteapellido2 = $this->db->f($this->acudienteapellido2_field);
				$this->acudientenombres = $this->db->f($this->acudientenombres_field);
				$this->acudienterelacion = $this->db->f($this->acudienterelacion_field);
				$this->acudientetelefonofijo = $this->db->f($this->acudientetelefonofijo_field);
				$this->acudientetelefonomovil = $this->db->f($this->acudientetelefonomovil_field);
				$this->acudienteciudadresidencia = $this->db->f($this->acudienteciudadresidencia_field);
				$this->acudientedireccionresidencia = $this->db->f($this->acudientedireccionresidencia_field);
				$this->institucion = $this->db->f($this->institucion_field);
				$this->egreso = $this->db->f($this->egreso_field);
				$this->saber11 = $this->db->f($this->saber11_field);
				$this->anhosaber = $this->db->f($this->anhosaber_field);
				$this->saber11matematica = $this->db->f($this->saber11matematica_field);
				$this->saber11espanol = $this->db->f($this->saber11espanol_field);
				$this->estudiaactualmente = $this->db->f($this->estudiaactualmente_field);
				$this->actualmenteestudiaotros = $this->db->f($this->actualmenteestudiaotros_field);
				$this->admisioncentroeducativo = $this->db->f($this->admisioncentroeducativo_field);
				$this->estatrabajando = $this->db->f($this->estatrabajando_field);
				$this->planescortoplazo = $this->db->f($this->planescortoplazo_field);
				$this->planescortoplazootros = $this->db->f($this->planescortoplazootros_field);
				$this->interesformacion = $this->db->f($this->interesformacion_field);
				$this->interesformacionotros = $this->db->f($this->interesformacionotros_field);
				$this->experienciavirtuales = $this->db->f($this->experienciavirtuales_field);
				$this->estrato = $this->db->f($this->estrato_field);
				$this->sisben = $this->db->f($this->sisben_field);
				$this->especiales = $this->db->f($this->especiales_field);
				$this->discapacidades = $this->db->f($this->discapacidades_field);
				$this->victima = $this->db->f($this->victima_field);
				$this->desmovilizado = $this->db->f($this->desmovilizado_field);
				$this->hijodesmovilizado = $this->db->f($this->hijodesmovilizado_field);
				$this->desplazado = $this->db->f($this->desplazado_field);
				$this->internet = $this->db->f($this->internet_field);
				$this->internetcalidad = $this->db->f($this->internetcalidad_field);
				$this->codigouniandes = $this->db->f($this->codigouniandes_field);
				$this->correouniandes = $this->db->f($this->correouniandes_field);
				$this->desactivado = $this->db->f($this->desactivado_field);
				$this->moodleid = $this->db->f($this->moodleid_field);
				//elements
				
				return true;
			}
			return false;
		}
		//LOAD RELATIONS -N
		
		function load_asistencia_collection()
		{
			$this->asistencia_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->asistencia_rel_table WHERE $this->idestudiante = $this->idestudiante_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new asistencia();
				$elemento->set_idasistencia($this->db->f($this->asistencia_relN_field));
				$elemento->load();
				$this->asistencia_collection[] = $elemento;
			}
			return true;
		}
		function get_asistencia_collection()
		{
			$this->load_asistencia_collection();
			return $this->asistencia_collection;
		}
		
		function load_entrega_collection()
		{
			$this->entrega_collection = array();
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->entrega_rel_table WHERE $this->idestudiante = $this->idestudiante_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new entrega();
				$elemento->set_identrega($this->db->f($this->entrega_relN_field));
				$elemento->load();
				$this->entrega_collection[] = $elemento;
			}
			return true;
		}
		function get_entrega_collection()
		{
			$this->load_entrega_collection();
			return $this->entrega_collection;
		}
		
		//LOAD RELATIONS -N (INVERSE) load one estudiante using a collection element (parent)
		
		
		function load_estudiante_by_asistencia_inverse($idasistencia)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->asistencia_rel_table WHERE $idasistencia = $this->asistencia_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new estudiante();
				$elemento->set_idestudiante ($this->db->f($this->idestudiante_field));
				$elemento->load();
				return $elemento;
			}
			return false;
		}
		
		
		function load_estudiante_by_entrega_inverse($identrega)
		{
			(string) $dbQuery     = "";
			$dbQuery = "SELECT * FROM $this->entrega_rel_table WHERE $identrega = $this->entrega_relN_field";
			$this->db->query( $dbQuery );
			while ($this->db->next_record()) 
			{
				$elemento = new estudiante();
				$elemento->set_idestudiante ($this->db->f($this->idestudiante_field));
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
			
			$dbQuery = "INSERT INTO $this->estudiante_table ";
		   	$dbQuery .= "(";
		   	
			$dbQuery .= $this->nombres_field.",";
			$dbQuery .= $this->apellido1_field.",";
			$dbQuery .= $this->apellido2_field.",";
			$dbQuery .= $this->genero_field.",";
			$dbQuery .= $this->estadocivil_field.",";
			$dbQuery .= $this->fechanacimiento_field.",";
			$dbQuery .= $this->nacionalidad_field.",";
			$dbQuery .= $this->tipodocumento_field.",";
			$dbQuery .= $this->numdocumento_field.",";
			$dbQuery .= $this->etnia_field.",";
			$dbQuery .= $this->email_field.",";
			$dbQuery .= $this->telefonofijo_field.",";
			$dbQuery .= $this->telefonomovil_field.",";
			$dbQuery .= $this->ciudadresidencia_field.",";
			$dbQuery .= $this->direccionresidencia_field.",";
			$dbQuery .= $this->acudienteapellido1_field.",";
			$dbQuery .= $this->acudienteapellido2_field.",";
			$dbQuery .= $this->acudientenombres_field.",";
			$dbQuery .= $this->acudienterelacion_field.",";
			$dbQuery .= $this->acudientetelefonofijo_field.",";
			$dbQuery .= $this->acudientetelefonomovil_field.",";
			$dbQuery .= $this->acudienteciudadresidencia_field.",";
			$dbQuery .= $this->acudientedireccionresidencia_field.",";
			$dbQuery .= $this->institucion_field.",";
			$dbQuery .= $this->egreso_field.",";
			$dbQuery .= $this->saber11_field.",";
			$dbQuery .= $this->anhosaber_field.",";
			$dbQuery .= $this->saber11matematica_field.",";
			$dbQuery .= $this->saber11espanol_field.",";
			$dbQuery .= $this->estudiaactualmente_field.",";
			$dbQuery .= $this->actualmenteestudiaotros_field.",";
			$dbQuery .= $this->admisioncentroeducativo_field.",";
			$dbQuery .= $this->estatrabajando_field.",";
			$dbQuery .= $this->planescortoplazo_field.",";
			$dbQuery .= $this->planescortoplazootros_field.",";
			$dbQuery .= $this->interesformacion_field.",";
			$dbQuery .= $this->interesformacionotros_field.",";
			$dbQuery .= $this->experienciavirtuales_field.",";
			$dbQuery .= $this->estrato_field.",";
			$dbQuery .= $this->sisben_field.",";
			$dbQuery .= $this->especiales_field.",";
			$dbQuery .= $this->discapacidades_field.",";
			$dbQuery .= $this->victima_field.",";
			$dbQuery .= $this->desmovilizado_field.",";
			$dbQuery .= $this->hijodesmovilizado_field.",";
			$dbQuery .= $this->desplazado_field.",";
			$dbQuery .= $this->internet_field.",";
			$dbQuery .= $this->internetcalidad_field.",";
			$dbQuery .= $this->codigouniandes_field.",";
			$dbQuery .= $this->correouniandes_field.",";
			$dbQuery .= $this->desactivado_field.",";
			$dbQuery .= $this->moodleid_field.",";
			
			$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			$dbQuery .= ") ";
			$dbQuery .= " VALUES (";
		   	
			$dbQuery .= " '$this->nombres',";
			$dbQuery .= " '$this->apellido1',";
			$dbQuery .= " '$this->apellido2',";
			$dbQuery .= " '$this->genero',";
			$dbQuery .= " '$this->estadocivil',";
			$dbQuery .= " '$this->fechanacimiento',";
			$dbQuery .= " '$this->nacionalidad',";
			$dbQuery .= " '$this->tipodocumento',";
			$dbQuery .= " '$this->numdocumento',";
			$dbQuery .= " '$this->etnia',";
			$dbQuery .= " '$this->email',";
			$dbQuery .= " '$this->telefonofijo',";
			$dbQuery .= " '$this->telefonomovil',";
			$dbQuery .= " '$this->ciudadresidencia',";
			$dbQuery .= " '$this->direccionresidencia',";
			$dbQuery .= " '$this->acudienteapellido1',";
			$dbQuery .= " '$this->acudienteapellido2',";
			$dbQuery .= " '$this->acudientenombres',";
			$dbQuery .= " '$this->acudienterelacion',";
			$dbQuery .= " '$this->acudientetelefonofijo',";
			$dbQuery .= " '$this->acudientetelefonomovil',";
			$dbQuery .= " '$this->acudienteciudadresidencia',";
			$dbQuery .= " '$this->acudientedireccionresidencia',";
			$dbQuery .= " '$this->institucion',";
			$dbQuery .= " '$this->egreso',";
			$dbQuery .= " '$this->saber11',";
			$dbQuery .= " '$this->anhosaber',";
			$dbQuery .= " '$this->saber11matematica',";
			$dbQuery .= " '$this->saber11espanol',";
			$dbQuery .= " '$this->estudiaactualmente',";
			$dbQuery .= " '$this->actualmenteestudiaotros',";
			$dbQuery .= " '$this->admisioncentroeducativo',";
			$dbQuery .= " '$this->estatrabajando',";
			$dbQuery .= " '$this->planescortoplazo',";
			$dbQuery .= " '$this->planescortoplazootros',";
			$dbQuery .= " '$this->interesformacion',";
			$dbQuery .= " '$this->interesformacionotros',";
			$dbQuery .= " '$this->experienciavirtuales',";
			$dbQuery .= " '$this->estrato',";
			$dbQuery .= " '$this->sisben',";
			$dbQuery .= " '$this->especiales',";
			$dbQuery .= " '$this->discapacidades',";
			$dbQuery .= " '$this->victima',";
			$dbQuery .= " '$this->desmovilizado',";
			$dbQuery .= " '$this->hijodesmovilizado',";
			$dbQuery .= " '$this->desplazado',";
			$dbQuery .= " '$this->internet',";
			$dbQuery .= " '$this->internetcalidad',";
			$dbQuery .= " '$this->codigouniandes',";
			$dbQuery .= " '$this->correouniandes',";
			if($this->desactivado == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "  $this->moodleid ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
		   	$dbQuery .= ") ";
		  
		   	$this->db->query( $dbQuery );
			
			$this->idestudiante = mysql_insert_id();
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		//DELETE
		function delete()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->estudiante_table WHERE $this->idestudiante_field = $this->idestudiante ";
	
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}
		//UPDATE
		function update()
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "UPDATE $this->estudiante_table SET ";
			
			
			
			$dbQuery .= "$this->nombres_field = '$this->nombres',";
			$dbQuery .= "$this->apellido1_field = '$this->apellido1',";
			$dbQuery .= "$this->apellido2_field = '$this->apellido2',";
			$dbQuery .= "$this->genero_field = '$this->genero',";
			$dbQuery .= "$this->estadocivil_field = '$this->estadocivil',";
			$dbQuery .= "$this->fechanacimiento_field = '$this->fechanacimiento',";
			$dbQuery .= "$this->nacionalidad_field = '$this->nacionalidad',";
			$dbQuery .= "$this->tipodocumento_field = '$this->tipodocumento',";
			$dbQuery .= "$this->numdocumento_field = '$this->numdocumento',";
			$dbQuery .= "$this->etnia_field = '$this->etnia',";
			$dbQuery .= "$this->email_field = '$this->email',";
			$dbQuery .= "$this->telefonofijo_field = '$this->telefonofijo',";
			$dbQuery .= "$this->telefonomovil_field = '$this->telefonomovil',";
			$dbQuery .= "$this->ciudadresidencia_field = '$this->ciudadresidencia',";
			$dbQuery .= "$this->direccionresidencia_field = '$this->direccionresidencia',";
			$dbQuery .= "$this->acudienteapellido1_field = '$this->acudienteapellido1',";
			$dbQuery .= "$this->acudienteapellido2_field = '$this->acudienteapellido2',";
			$dbQuery .= "$this->acudientenombres_field = '$this->acudientenombres',";
			$dbQuery .= "$this->acudienterelacion_field = '$this->acudienterelacion',";
			$dbQuery .= "$this->acudientetelefonofijo_field = '$this->acudientetelefonofijo',";
			$dbQuery .= "$this->acudientetelefonomovil_field = '$this->acudientetelefonomovil',";
			$dbQuery .= "$this->acudienteciudadresidencia_field = '$this->acudienteciudadresidencia',";
			$dbQuery .= "$this->acudientedireccionresidencia_field = '$this->acudientedireccionresidencia',";
			$dbQuery .= "$this->institucion_field = '$this->institucion',";
			$dbQuery .= "$this->egreso_field = '$this->egreso',";
			$dbQuery .= "$this->saber11_field = '$this->saber11',";
			$dbQuery .= "$this->anhosaber_field = '$this->anhosaber',";
			$dbQuery .= "$this->saber11matematica_field = '$this->saber11matematica',";
			$dbQuery .= "$this->saber11espanol_field = '$this->saber11espanol',";
			$dbQuery .= "$this->estudiaactualmente_field = '$this->estudiaactualmente',";
			$dbQuery .= "$this->actualmenteestudiaotros_field = '$this->actualmenteestudiaotros',";
			$dbQuery .= "$this->admisioncentroeducativo_field = '$this->admisioncentroeducativo',";
			$dbQuery .= "$this->estatrabajando_field = '$this->estatrabajando',";
			$dbQuery .= "$this->planescortoplazo_field = '$this->planescortoplazo',";
			$dbQuery .= "$this->planescortoplazootros_field = '$this->planescortoplazootros',";
			$dbQuery .= "$this->interesformacion_field = '$this->interesformacion',";
			$dbQuery .= "$this->interesformacionotros_field = '$this->interesformacionotros',";
			$dbQuery .= "$this->experienciavirtuales_field = '$this->experienciavirtuales',";
			$dbQuery .= "$this->estrato_field = '$this->estrato',";
			$dbQuery .= "$this->sisben_field = '$this->sisben',";
			$dbQuery .= "$this->especiales_field = '$this->especiales',";
			$dbQuery .= "$this->discapacidades_field = '$this->discapacidades',";
			$dbQuery .= "$this->victima_field = '$this->victima',";
			$dbQuery .= "$this->desmovilizado_field = '$this->desmovilizado',";
			$dbQuery .= "$this->hijodesmovilizado_field = '$this->hijodesmovilizado',";
			$dbQuery .= "$this->desplazado_field = '$this->desplazado',";
			$dbQuery .= "$this->internet_field = '$this->internet',";
			$dbQuery .= "$this->internetcalidad_field = '$this->internetcalidad',";
			$dbQuery .= "$this->codigouniandes_field = '$this->codigouniandes',";
			$dbQuery .= "$this->correouniandes_field = '$this->correouniandes',";
			$dbQuery .= "$this->desactivado_field = ";
			if($this->desactivado == false) $dbQuery .= "0,"; else $dbQuery .= "1,";
			$dbQuery .= "$this->moodleid_field =  $this->moodleid ,";
			
		   	
		   	$dbQuery = preg_replace('/,$/', ' ', $dbQuery);
			
			$dbQuery .= " WHERE $this->idestudiante_field = $this->idestudiante ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;              
			return true;
		}
		//ADD TO COLLECTION
		
		function add_asistencia ($idasistencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->asistencia_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idestudiante_field,";
		   	$dbQuery .= " $this->asistencia_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idestudiante,";
		   	$dbQuery .= " $idasistencia";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		function add_entrega ($identrega)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "INSERT INTO $this->entrega_rel_table ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idestudiante_field,";
		   	$dbQuery .= " $this->entrega_relN_field";
		   	$dbQuery .= ")";
		   	$dbQuery .= " VALUES ";
		   	$dbQuery .= "(";
		   	$dbQuery .= " $this->idestudiante,";
		   	$dbQuery .= " $identrega";
		   	$dbQuery .= ")";
		   	
		   	$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;
			return true;
		}
		
		//REMOVE FROM COLLECTION
		
		function remove_asistencia ($idasistencia)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->asistencia_rel_table ";
			$dbQuery.= " WHERE $this->idestudiante_field = $this->idestudiante ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->asistencia_relN_field = $idasistencia ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		function remove_entrega ($identrega)
		{
			(string) $dbQuery     = "";
			
			$dbQuery = "DELETE FROM $this->entrega_rel_table ";
			$dbQuery.= " WHERE $this->idestudiante_field = $this->idestudiante ";
			$dbQuery.= " AND ";
			$dbQuery.= " $this->entrega_relN_field = $identrega ";
			
			$this->db->query( $dbQuery );
			
			if ($this->db->affected_rows() == 0) return false;               
			return true;
		}  		
		
		
		//GETTERS AND SETTERS
		
		function get_idestudiante()
		{
			return $this->idestudiante;
		}
 		function set_idestudiante($id)
		{
			$this->idestudiante=$id;
		}		
		//simple attributes
		
		function get_nombres()
		{
			return $this->nombres;
		}
		function set_nombres($value)
		{
			$this->nombres = $value;
		}
		
		function get_apellido1()
		{
			return $this->apellido1;
		}
		function set_apellido1($value)
		{
			$this->apellido1 = $value;
		}
		
		function get_apellido2()
		{
			return $this->apellido2;
		}
		function set_apellido2($value)
		{
			$this->apellido2 = $value;
		}
		
		function get_genero()
		{
			return $this->genero;
		}
		function set_genero($value)
		{
			$this->genero = $value;
		}
		
		function get_estadocivil()
		{
			return $this->estadocivil;
		}
		function set_estadocivil($value)
		{
			$this->estadocivil = $value;
		}
		
		function get_fechanacimiento()
		{
			return $this->fechanacimiento;
		}
		function set_fechanacimiento($value)
		{
			$this->fechanacimiento = $value;
		}
		
		function get_nacionalidad()
		{
			return $this->nacionalidad;
		}
		function set_nacionalidad($value)
		{
			$this->nacionalidad = $value;
		}
		
		function get_tipodocumento()
		{
			return $this->tipodocumento;
		}
		function set_tipodocumento($value)
		{
			$this->tipodocumento = $value;
		}
		
		function get_numdocumento()
		{
			return $this->numdocumento;
		}
		function set_numdocumento($value)
		{
			$this->numdocumento = $value;
		}
		
		function get_etnia()
		{
			return $this->etnia;
		}
		function set_etnia($value)
		{
			$this->etnia = $value;
		}
		
		function get_email()
		{
			return $this->email;
		}
		function set_email($value)
		{
			$this->email = $value;
		}
		
		function get_telefonofijo()
		{
			return $this->telefonofijo;
		}
		function set_telefonofijo($value)
		{
			$this->telefonofijo = $value;
		}
		
		function get_telefonomovil()
		{
			return $this->telefonomovil;
		}
		function set_telefonomovil($value)
		{
			$this->telefonomovil = $value;
		}
		
		function get_ciudadresidencia()
		{
			return $this->ciudadresidencia;
		}
		function set_ciudadresidencia($value)
		{
			$this->ciudadresidencia = $value;
		}
		
		function get_direccionresidencia()
		{
			return $this->direccionresidencia;
		}
		function set_direccionresidencia($value)
		{
			$this->direccionresidencia = $value;
		}
		
		function get_acudienteapellido1()
		{
			return $this->acudienteapellido1;
		}
		function set_acudienteapellido1($value)
		{
			$this->acudienteapellido1 = $value;
		}
		
		function get_acudienteapellido2()
		{
			return $this->acudienteapellido2;
		}
		function set_acudienteapellido2($value)
		{
			$this->acudienteapellido2 = $value;
		}
		
		function get_acudientenombres()
		{
			return $this->acudientenombres;
		}
		function set_acudientenombres($value)
		{
			$this->acudientenombres = $value;
		}
		
		function get_acudienterelacion()
		{
			return $this->acudienterelacion;
		}
		function set_acudienterelacion($value)
		{
			$this->acudienterelacion = $value;
		}
		
		function get_acudientetelefonofijo()
		{
			return $this->acudientetelefonofijo;
		}
		function set_acudientetelefonofijo($value)
		{
			$this->acudientetelefonofijo = $value;
		}
		
		function get_acudientetelefonomovil()
		{
			return $this->acudientetelefonomovil;
		}
		function set_acudientetelefonomovil($value)
		{
			$this->acudientetelefonomovil = $value;
		}
		
		function get_acudienteciudadresidencia()
		{
			return $this->acudienteciudadresidencia;
		}
		function set_acudienteciudadresidencia($value)
		{
			$this->acudienteciudadresidencia = $value;
		}
		
		function get_acudientedireccionresidencia()
		{
			return $this->acudientedireccionresidencia;
		}
		function set_acudientedireccionresidencia($value)
		{
			$this->acudientedireccionresidencia = $value;
		}
		
		function get_institucion()
		{
			return $this->institucion;
		}
		function set_institucion($value)
		{
			$this->institucion = $value;
		}
		
		function get_egreso()
		{
			return $this->egreso;
		}
		function set_egreso($value)
		{
			$this->egreso = $value;
		}
		
		function get_saber11()
		{
			return $this->saber11;
		}
		function set_saber11($value)
		{
			$this->saber11 = $value;
		}
		
		function get_anhosaber()
		{
			return $this->anhosaber;
		}
		function set_anhosaber($value)
		{
			$this->anhosaber = $value;
		}
		
		function get_saber11matematica()
		{
			return $this->saber11matematica;
		}
		function set_saber11matematica($value)
		{
			$this->saber11matematica = $value;
		}
		
		function get_saber11espanol()
		{
			return $this->saber11espanol;
		}
		function set_saber11espanol($value)
		{
			$this->saber11espanol = $value;
		}
		
		function get_estudiaactualmente()
		{
			return $this->estudiaactualmente;
		}
		function set_estudiaactualmente($value)
		{
			$this->estudiaactualmente = $value;
		}
		
		function get_actualmenteestudiaotros()
		{
			return $this->actualmenteestudiaotros;
		}
		function set_actualmenteestudiaotros($value)
		{
			$this->actualmenteestudiaotros = $value;
		}
		
		function get_admisioncentroeducativo()
		{
			return $this->admisioncentroeducativo;
		}
		function set_admisioncentroeducativo($value)
		{
			$this->admisioncentroeducativo = $value;
		}
		
		function get_estatrabajando()
		{
			return $this->estatrabajando;
		}
		function set_estatrabajando($value)
		{
			$this->estatrabajando = $value;
		}
		
		function get_planescortoplazo()
		{
			return $this->planescortoplazo;
		}
		function set_planescortoplazo($value)
		{
			$this->planescortoplazo = $value;
		}
		
		function get_planescortoplazootros()
		{
			return $this->planescortoplazootros;
		}
		function set_planescortoplazootros($value)
		{
			$this->planescortoplazootros = $value;
		}
		
		function get_interesformacion()
		{
			return $this->interesformacion;
		}
		function set_interesformacion($value)
		{
			$this->interesformacion = $value;
		}
		
		function get_interesformacionotros()
		{
			return $this->interesformacionotros;
		}
		function set_interesformacionotros($value)
		{
			$this->interesformacionotros = $value;
		}
		
		function get_experienciavirtuales()
		{
			return $this->experienciavirtuales;
		}
		function set_experienciavirtuales($value)
		{
			$this->experienciavirtuales = $value;
		}
		
		function get_estrato()
		{
			return $this->estrato;
		}
		function set_estrato($value)
		{
			$this->estrato = $value;
		}
		
		function get_sisben()
		{
			return $this->sisben;
		}
		function set_sisben($value)
		{
			$this->sisben = $value;
		}
		
		function get_especiales()
		{
			return $this->especiales;
		}
		function set_especiales($value)
		{
			$this->especiales = $value;
		}
		
		function get_discapacidades()
		{
			return $this->discapacidades;
		}
		function set_discapacidades($value)
		{
			$this->discapacidades = $value;
		}
		
		function get_victima()
		{
			return $this->victima;
		}
		function set_victima($value)
		{
			$this->victima = $value;
		}
		
		function get_desmovilizado()
		{
			return $this->desmovilizado;
		}
		function set_desmovilizado($value)
		{
			$this->desmovilizado = $value;
		}
		
		function get_hijodesmovilizado()
		{
			return $this->hijodesmovilizado;
		}
		function set_hijodesmovilizado($value)
		{
			$this->hijodesmovilizado = $value;
		}
		
		function get_desplazado()
		{
			return $this->desplazado;
		}
		function set_desplazado($value)
		{
			$this->desplazado = $value;
		}
		
		function get_internet()
		{
			return $this->internet;
		}
		function set_internet($value)
		{
			$this->internet = $value;
		}
		
		function get_internetcalidad()
		{
			return $this->internetcalidad;
		}
		function set_internetcalidad($value)
		{
			$this->internetcalidad = $value;
		}
		
		function get_codigouniandes()
		{
			return $this->codigouniandes;
		}
		function set_codigouniandes($value)
		{
			$this->codigouniandes = $value;
		}
		
		function get_correouniandes()
		{
			return $this->correouniandes;
		}
		function set_correouniandes($value)
		{
			$this->correouniandes = $value;
		}
		
		function get_desactivado()
		{
			return $this->desactivado;
		}
		function set_desactivado($value)
		{
			$this->desactivado = $value;
		}
		
		function get_moodleid()
		{
			return $this->moodleid;
		}
		function set_moodleid($value)
		{
			$this->moodleid = $value;
		}
		
		//elements
		
 	}
 ?>
 