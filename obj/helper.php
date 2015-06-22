  <?php
	require_once("sigmasas.php");
 	class Helper
 	{
 		var $contenedor ;
 		function Helper($cont)
 		{
 			$this->contenedor = $cont;
 		}
		function filtrarBloquesAutorizados($cursos, $bloques)
		{
			$bloquesautorizados = array();

			foreach($cursos as $curso)
			{
				foreach($bloques as $bloque)
				{
					//XXX: Esta parte tiene ids quemados de cursos. es importante modificar a futuro!
					if($curso->get_idcurso()==1) //1 PC
					{
						// [VU - MP] , [PP], [TGP]
						if
						(
							strpos($bloque->get_descripcion(), '[VU - MP]')!==false
							|| 
							strpos($bloque->get_descripcion(), '[PP]')!==false
							|| 
							strpos($bloque->get_descripcion(), '[TGP]')!==false
						)
						{
							print_variable("PC","ENTRO");
							$bloquesautorizados[$bloque->get_idbloque()]=$bloque;
						}
					}
					else if($curso->get_idcurso()==2)//2 ES
					{
						//[AE], [PE]
						if
						(
							strpos($bloque->get_descripcion(), '[AE]')!==false
							|| 
							strpos($bloque->get_descripcion(), '[PE]')!==false
						)
						{
							print_variable("ES","ENTRO");
							$bloquesautorizados[$bloque->get_idbloque()]=$bloque;
						}
					}
					else if($curso->get_idcurso()==4)//4 VU
					{
						//[VU - MP], [CAP]
						if
						(
							strpos($bloque->get_descripcion(), '[VU - MP]')!==false
							|| 
							strpos($bloque->get_descripcion(), '[CAP]')!==false
						)
						{
							print_variable("VU","ENTRO");
							$bloquesautorizados[$bloque->get_idbloque()]=$bloque;
						}
					}
				}
			}
			print_variable("numero de bloques autorizados ",count($bloquesautorizados));
			return $bloquesautorizados;
		}

 		function darCursosAutorizados($username, $cursos)
 		{
 			$resultado = array();

 			foreach($cursos as $curso)
 			{
 				//para cada curso, recorrer secciones
				$secciones = $curso->get_seccion_collection();
 				foreach ($secciones as $seccion) 
 				{
 					$responsable = $seccion -> get_usuario_element(); //dar responsable
 					//print_variable("login", "[".$responsable -> get_login()."]");
 					if($responsable -> get_login() == $username)
 					{
 						//si el usuario corresponde al responsable, entonces entra en el resultado
 						$resultado[$curso->get_idcurso()]=$curso;
 					}
 				}
 			}
 			return $resultado;
 		}
 		function darGruposAutorizados($username, $cursos)
 		{
 			$resultado = array();

 			foreach($cursos as $curso)
 			{
 				//para cada curso, recorrer secciones
				$secciones = $curso->get_seccion_collection();
 				foreach ($secciones as $seccion) 
 				{
 					$responsable = $seccion -> get_usuario_element(); //dar responsable
 					if($responsable -> get_login() == $username)
 					{
 						//si el usuario corresponde al responsable, entonces entra en el resultado
 						$grupo=$seccion->get_grupo_element();
 						$resultado[$grupo->get_idgrupo()]=$grupo;
 					}
 				}
 			}
 			return $resultado;
 		}

 		function eliminarAsistencias($asistencias)
 		{
 			foreach ($asistencias as $asistencia ) 
 			{
 				//buscar el estudiante del cual es la asistencia
 				$estudiante = new estudiante ();
 				$estudiante = $estudiante->load_estudiante_by_asistencia_inverse($asistencia->get_idasistencia());
 				//desvincular la asistencia del estudiante en particular
 				$estudiante->remove_asistencia($asistencia->get_idasistencia());
 				//eliminar el registro de asistencia
 				$asistencia->delete();
 			}
 		}
 		function moverAsistencias($asistencias,  $fecha_nueva, $bloque_nuevo)
 		{
 			foreach ($asistencias as $asistencia ) 
 			{
 				$asistencia->set_fecha($fecha_nueva);
 				$asistencia->set_bloque_element($bloque_nuevo);
 				$asistencia->update();
 			}

 		}
 		
 		function ordenarBloques($bloques, $ocultar = true)
 		{
 			$filtrados=array();
 			$ordenes = array();
 			$llaves = array();
 			$resultado = array();

 			foreach ($bloques as $bloque)
 			{
 				if($ocultar == true)
 				{
					if($bloque->get_mostrar()=="1")
	 				{
	 					$filtrados [$bloque->get_idbloque()] = $bloque;
	 					$ordenes[] = $bloque->get_orden();
	 					$llaves[] = $bloque->get_idbloque();
 					}
 				}
 				else
 				{
 					$filtrados [$bloque->get_idbloque()] = $bloque;
 					$ordenes[] = $bloque->get_orden();
 					$llaves[] = $bloque->get_idbloque();
 				}
 				
 			}

 			array_multisort($ordenes, $llaves); 
 			
 			
 			foreach ($llaves as $llave ) 
 			{
 				$resultado[] = $filtrados[$llave];
 			}
 			return $resultado;
 		}
 		function darAsistencias_por_estudianteSeccion ($estudiante, $seccion)
 		{
 			$asistenciastotales = $estudiante->get_asistencia_collection();
 			//print_recursive("asistencia" , $asistenciastotales);
 			$resultado = array();
 			foreach($asistenciastotales as $asistencia)
 			{
 				if($asistencia->get_seccion_element()->get_idseccion() == $seccion->get_idseccion())
 				{	
 					$idbloque=$asistencia->get_bloque_element()->get_idbloque();
 					$fecha=$asistencia->get_fecha();
 					$resultado[$fecha][$idbloque] = $asistencia;
 				}
 			}
 			return $resultado;
 		}

 		function ordenarEstudiantes ($estudiantes)
 		{
 			$resultado = array();


 			$apellidos= array();
 			$codigos = array();
 			$objetos= array();


 			foreach ($estudiantes as $estudiante) 
 			{
 				$objetos[$estudiante->get_codigouniandes()]=$estudiante;
 				$apellidos[] = $estudiante->get_apellido1();
 				$codigos[] = $estudiante->get_codigouniandes();
 			}

 			array_multisort($apellidos, $codigos); 
 			
 			
 			foreach ($codigos as $c ) 
 			{
 				$resultado[] = $objetos[$c];
 			}
 			return $resultado;

 		}
 		function darSeccion_por_grupoCurso($curso, $grupo)
 		{
 			$secciones = $curso->get_seccion_collection();
 			$resultado = array();
 			foreach ($secciones as $seccion ) 
 			{
 				if($seccion->get_grupo_element()->get_idgrupo() == $grupo->get_idgrupo())
 				{
 					return $seccion;
 				}
 			}
 			return false;
 		}
 		function darAsistencias_por_estudianteSeccionBloqueFecha ($estudiante, $seccion, $bloque, $fecha)
 		{
 			$asistenciastotales = $estudiante->get_asistencia_collection();
 			foreach($asistenciastotales as $asistencia)
 			{
 				if($asistencia->get_seccion_element()->get_idseccion() == $seccion->get_idseccion())
 				{
 					if($asistencia->get_bloque_element()->get_idbloque() == $bloque->get_idbloque())
 					{
 						if($asistencia->get_fecha () == $fecha)
 						{
 							 return $asistencia;
 						}
 					}
 				}
 			}
 			return false;
 		}
 		function guardarAsistencias($idestudiantes, $asistencias, $justificaciones, $fecha, $seccion, $bloque, $registradapor, $observaciones)
 		{
 			foreach($idestudiantes as $idestudiante)
 			{
 				$estudiante = new estudiante ( $idestudiante); $estudiante->load();
 				$asistencia = $this->darAsistencias_por_estudianteSeccionBloqueFecha ($estudiante, $seccion, $bloque, $fecha);
 				if($asistencia == false) //no se ha registrado
 				{
 					$asistencia  = new asistencia();
 					if(isset($asistencias[$idestudiante])) $asistencia-> set_asiste(true); else $asistencia-> set_asiste(false);
 					if(isset($justificaciones[$idestudiante])) $asistencia-> set_justificacion(true); else $asistencia-> set_justificacion(false);
 					if(isset($observaciones[$idestudiante])) $asistencia-> set_observaciones($observaciones[$idestudiante]);
 					$asistencia->set_fecha ($fecha);
 					$asistencia->set_registradapor($registradapor);
 					$asistencia->set_seccion_element($seccion);
 					$asistencia->set_bloque_element($bloque);
 					$asistencia->insert();
 					$estudiante->add_asistencia($asistencia->get_idasistencia());
 				}
 				else
 				{
 					if(isset($asistencias[$idestudiante])) $asistencia-> set_asiste(true); else $asistencia-> set_asiste(false);
 					if(isset($justificaciones[$idestudiante])) $asistencia-> set_justificacion(true); else $asistencia-> set_justificacion(false);
 					if(isset($observaciones[$idestudiante])) $asistencia-> set_observaciones($observaciones[$idestudiante]);
 					$asistencia->update();
 				}
 			}
 		}
 		function darEntregas_por_estudianteSeccionSemanaActividad ( $estudiante, $actividad , $semana)
 		{
 			$entregastotales = $estudiante->get_entrega_collection();
 			foreach($entregastotales as $entrega)
 			{
 				if($entrega->get_actividad_element()->get_idactividad() == $actividad->get_idactividad())
 				{
 					
 						return $entrega;
 				}
 			}
 			return false;
 		}
 		function crearMatrizCalificaciones($estudiantes, $actividades)
 		{
			$js_inject ='<script type="text/javascript">';
			$js_inject.="var matrix_spin_calificacion = new Array();var array_indices = new Array();\n";
 			$con=0;
 			foreach ($estudiantes as $est) 
			{
				$js_inject.= "matrix_spin_calificacion[".$est->get_idestudiante()."] = new Array();\n";
				foreach ($actividades as $act) 
				{
					if($act->get_calificable()=="1")
					{
						$js_inject.= "matrix_spin_calificacion[".$est->get_idestudiante()."][".$act->get_idactividad()."] = document.createElement('div');\n";
						$js_inject.= "array_indices[".$con."]='".$est->get_idestudiante()."_".$act->get_idactividad()."';\n";
						//$js_inject.= "console.log(".$est->get_idestudiante().");\n";
						$con++;	
					}
				}
			}
			$js_inject .="</script>\n";
			return $js_inject;
 		}
 		function guardarEntregas($idestudiantes, $idactividades, $entregas,$semana, $seccion, $registradapor, $observaciones, $calificaciones)
 		{
 			foreach($idestudiantes as $idestudiante)
 			{
 				$estudiante = new estudiante ( $idestudiante); $estudiante->load();
 				foreach ($idactividades as $idactividad) 
 				{
 					$actividad = new actividad($idactividad); $actividad->load();
 					$entrega = $this->darEntregas_por_estudianteSeccionSemanaActividad ( $estudiante, $actividad , $semana);
 					if($entrega == false)
 					{
 						$entrega = new entrega();
 						if(isset($entregas[$idestudiante][$idactividad])) $entrega -> set_realizada (true);
 						else  $entrega -> set_realizada (false);

 						if(isset($observaciones[$idestudiante][$idactividad])) $entrega->set_comentario($observaciones[$idestudiante][$idactividad]);
 						else $entrega->set_comentario("");

 						if(isset($calificaciones[$idestudiante][$idactividad])) $entrega->set_calificacion($calificaciones[$idestudiante][$idactividad]);
 						else $entrega->set_calificacion(0);

 						$entrega->set_registradapor($registradapor);

 						$entrega->set_actividad_element($actividad);

 						$entrega->insert();
 						$estudiante->add_entrega($entrega->get_identrega());
 					}	
 					else
 					{
 						if(isset($entregas[$idestudiante][$idactividad])) $entrega -> set_realizada (true);
 						else  $entrega -> set_realizada (false);
 						
 						if(isset($observaciones[$idestudiante][$idactividad])) $entrega->set_comentario($observaciones[$idestudiante][$idactividad]);
 						else $entrega->set_comentario("");

 						if(isset($calificaciones[$idestudiante][$idactividad])) $entrega->set_calificacion($calificaciones[$idestudiante][$idactividad]);
 						else $entrega->set_calificacion(0);

 						$entrega->update();
 					}
 				}
 				
 			}
 		}
 	}
 ?>
 