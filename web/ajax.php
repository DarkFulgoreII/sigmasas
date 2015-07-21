<?
	require_once("../config.php");

	$serviceresult="";
	if(isset($_REQUEST['service']))
	{
		if( $_REQUEST['service']=='darEstudiantesPorGrupo' )
		{
			$idgrupo = $_REQUEST['idgrupo'];
			
			$seleccionados = $helper->darEstudiantesPorGrupo($idgrupo);
			//generate code

			$resultado = '<select class="form-control" name = "combo_estudiante" id="combo_estudiante">';
			foreach ($seleccionados as $est) 
			{
				$nombrecompleto = $est->get_apellido1()." ".$est->get_apellido2()." ".$est->get_nombres();
				$resultado .='<option value="'.$est->get_idestudiante().'">'.utf8_encode($nombrecompleto).'</option>';
			}
			$resultado .='</select>';
			$serviceresult = $resultado;
		}
		else if ($_REQUEST['service']=='darActividadesPorCursoSemana' )
		{
			$idcurso = $_REQUEST['idcurso'];
			$numerosemana = $_REQUEST['numerosemana'];
			
			$entregas = $helper->darActividadesPorCursoSemana($idcurso, $numerosemana );

			$resultado = '<select class="form-control" name = "combo_actividad" id="combo_actividad">';
			foreach ($entregas as $ent) 
			{
				$resultado .='<option value="'.$ent->get_idactividad().'">'.utf8_encode($ent->get_nombre()).'</option>';
			}
			$resultado .='</select>';
			$serviceresult = $resultado;
		}
		
		eecho($serviceresult);	
	}
?>
