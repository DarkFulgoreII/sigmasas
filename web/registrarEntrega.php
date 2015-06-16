<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = $contenedor->get_curso_collection();
	// cargar los posibles grupos
	$grupos = $contenedor->get_grupo_collection();

	//print_recursive("cursos", $cursos);
	//print_recursive("grupos", $grupos);
	print_recursive("REQUEST", $_REQUEST);
	print_recursive("SESSION", $_SESSION);

	validar_referer($_SESSION['serverurl']);
	

	//accion de generar - debe revisar primero si ya habían registros y debe cargarlos

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar")
	{
		//cargar los estudiantes de la seccion
		$curso = new curso ();
		$curso->set_idcurso ($_REQUEST['combo_curso']);
		$curso->load();

		$grupo = new grupo();
		$grupo->set_idgrupo($_REQUEST['combo_grupo']);
		$grupo->load();

		$seccion= $helper->darSeccion_por_grupoCurso($curso, $grupo);
		
		$estudiantes = array();
		if($seccion != false)
		{
			$estudiantes = $seccion ->get_estudiante_collection();
			$estudiantes = $helper ->ordenarEstudiantes($estudiantes);
		}
		
		$semana = $_REQUEST['combo_semana'];

		//traer las actividades que corresponden a ese curso y esa semana
		$actividades = array();
		foreach ($curso->get_actividad_collection() as $act ) 
		{
			if($act->get_numerosemana() == $semana)
			{
				$actividades[] = $act;
			}
		} 

		//traer las entregas que corresponden a cada estudiante y por cada actividad
		$entregas = array();
		foreach ($estudiantes as $estudiante) 
		{
			foreach($actividades as $actividad)
			{
				$entrega = $helper-> darEntregas_por_estudianteSeccionSemanaActividad ( $estudiante, $actividad , $semana);
				if($entrega != false)
				{
					$entregas[$estudiante->get_idestudiante()][$actividad->get_idactividad()] =$entrega;	
				}
				
			}
		}
	}
	//accion de guardar 
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		/*tomar los elementos del request
		[action] => guardar
	    [hidden_curso] => 1
	    [hidden_grupo] => 1
	    [hidden_seccion] => 1
	    [hidden_semana] => 1
	    [estudiantes] => Array[pos]=idestudiante
	    [actividades] =>Array[pos]=idactividad
	    [checkbox_entrega] => Array[idestudiante][idactividad]=true
	 
	    */
	    $semana = $_REQUEST['hidden_semana'];
	    $seccion = new seccion($_REQUEST['hidden_seccion']); $seccion->load();
	    $estudiantes = $_REQUEST['estudiantes'];
	    $actividades = $_REQUEST['actividades'];
	    $entregas = array();
	    if(isset($_REQUEST['text_observaciones'])) $observaciones = $_REQUEST['text_observaciones'];
	    print_recursive("observaciones", $observaciones);
	    if(isset($_REQUEST['checkbox_entrega'])) $entregas = $_REQUEST['checkbox_entrega'];
	    $registradapor = $_SESSION['userName'];
	    $helper->guardarEntregas($estudiantes, $actividades, $entregas, $semana, $seccion, $registradapor, $observaciones);
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registrar entrega</title>
		<?
			include_javascript();
		?>
	</head>
	<body>
		<div class="well" ><img src="../img/cabezote.png" class="img-responsive" alt="Sigma" width="1055" height="118"></div>
		
		<?include ("../inc/menu.php");?>

		<? if(isset($_SESSION["userName"])): ?>
			<? if(!isset($_REQUEST["action"])){ ?>
				<div class="well" >
					
					<h4>Registro de entregas</h4>
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "generar" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Seleccione el curso: 
								</th>
								<th>
									Seleccione el grupo: 
								</th>
								<th>
									Seleccione la semana: 
								</th>
								
							</tr>
							<tr>
								<td>
									<select class="form-control" name = "combo_curso" id="combo_curso">
										<? foreach($cursos as $curso): ?>
						  					<option value="<?= $curso->get_idcurso() ?>"  ><?= eecho ($curso->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
								
								<td>
									<select class="form-control" name = "combo_grupo" id="combo_grupo">
										<? foreach($grupos as $grupo): ?>
						  					<option value="<?= $grupo->get_idgrupo() ?>" ><?= eecho ($grupo->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
								<td>
									<select class="form-control" name = "combo_semana" id="combo_bloque">
										<? for ( $sem = 0; $sem < 17; $sem++ ): ?>
						  					<option value="<?= $sem ?>" ><?= eecho ("Semana : ".$sem) ?></option>
						  				<? endfor; ?>
									</select>
								</td>
							</tr>
							<tr>
								
								<td colspan= "4">
									<center>
										<input class="btn btn-default btn-sm" id = "submit_generar" type = "submit" value="Llenar planilla" onClick="document.getElementById('action').value='generar'; "/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./registrarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					<h4>Registro de entregas</h4>
					<table class="table table-bordered">
						<tr>
							<th>
								 <span class="glyphicon glyphicon-book"></span> Curso
							</th>
							<th>
								 <span class="glyphicon glyphicon-user"></span> Grupo
							</th>
							<th>
								<span class="glyphicon glyphicon-time"></span> Semana
							</th>
						</tr>
						<tr>
							<td>
								<small><? eecho($curso->get_nombre());?></small>
							</td>
							
							<td>
								<small><? eecho($seccion->get_descripcion()." CRN: ".$seccion->get_crn()); ?></small>
							</td>
							<td>
								<small><? eecho ("Semana : "+$semana);?></small>
							</td>
						</tr>
					</table>
				</div>
				<div class="row-fluid">
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_curso" id= "hidden_curso" value = "<?=$_REQUEST['combo_curso']?>" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<input type = "hidden" name= "hidden_seccion" id= "hidden_seccion" value = "<?=$seccion->get_idseccion()?>" />
						<input type = "hidden" name= "hidden_semana" id= "hidden_semana" value = "<?=$_REQUEST['combo_semana']?>" />
						<table class="table table-hover">	
							<tr>
								<th colspan = "3"><h4>Datos básicos</h4></th>
								<th colspan="<?= count($actividades)*2 ?>"><h4>Actividades</h4></th>	
							</tr>
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Apellidos</h4></th>
								<th><h4>Nombres</h4></th>
								<?foreach ($actividades as $actividad ) :?>
									<th colspan="2">
										<small>
											<font size="1">
												<? eecho( $actividad->get_nombre() ); ?>
											</font>
										</small>
										<input type = "hidden" name= "actividades[] " id= "actividades[] " value = "<?= $actividad->get_idactividad()?>" />
									</th>	
								<?endforeach;?>
							</tr>
							<? foreach($estudiantes as $estudiante):?>
								<tr>
									<td><small><?= $estudiante->get_codigouniandes() ?></small></td>
									<td><small><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></small></td>
									<td><small><?= $estudiante->get_nombres() ?></small></td>
									
									<?foreach ($actividades as $actividad ) :?>
										<?
											$activaentrega = "";
											$claseentrega = "class='danger'";
											
											if(isset($entregas[$estudiante->get_idestudiante()][$actividad->get_idactividad()]))
											{
												if($entregas[$estudiante->get_idestudiante()][$actividad->get_idactividad()]->get_realizada()==1)
												{
													$activaentrega = "checked";
													$claseentrega = "class='success'";
												}	
											}
										?>	
										<td <?= $claseentrega ?>>
											<div class="checkbox">
												<label>
													<input 
													type="checkbox" 
													name="checkbox_entrega[<?= $estudiante->get_idestudiante() ?>][<?= $actividad->get_idactividad() ?>]" 
													id="checkbox_entrega[<?= $estudiante->get_idestudiante() ?>][<?= $actividad->get_idactividad() ?>]"   
													<?= $activaentrega ?>  
												/>
												<font size="1">Entrega:</font>
												</label> 
											</div>
										</td>
										<?
											if(isset ($entregas[$estudiante->get_idestudiante()][$actividad->get_idactividad()]))
											{
												$contenidoobservaciones = $entregas[$estudiante->get_idestudiante()][$actividad->get_idactividad()]->get_comentario();
											}
											else
											{
												$contenidoobservaciones = "";
											}
										?>
										<td <?= $claseentrega ?>>
											<?
												$claseboton = "btn btn-default btn-sm";
												if(strlen($contenidoobservaciones)>1) $claseboton.= " btn-success";
											?>
											<a 
												style="font-size: 10px;"
												class="<?=$claseboton?>"
												onClick="mostrar_ocultar('div_observaciones<?= $estudiante->get_idestudiante() ?>_<?= $actividad->get_idactividad() ?>');">
												Observaciones:
											</a>
											<div 
												name="div_observaciones<?= $estudiante->get_idestudiante() ?>_<?= $actividad->get_idactividad() ?>"
												id="div_observaciones<?= $estudiante->get_idestudiante() ?>_<?= $actividad->get_idactividad() ?>"
												style="display:none;"
											>
												<small>
													<textarea 
														style="font-size: 10px;" 
														rows="4" 
														cols="50" 
														name="text_observaciones[<?= $estudiante->get_idestudiante() ?>][<?= $actividad->get_idactividad() ?>]" 
														id="text_observaciones[<?= $estudiante->get_idestudiante() ?>][<?= $actividad->get_idactividad() ?>]"
													><?=$contenidoobservaciones?></textarea>
												</small>
											<div>
										</td>
									<?endforeach;?>
									<input type = "hidden" name= "estudiantes[] " id= "estudiantes[] " value = "<?= $estudiante->get_idestudiante()?>" />
								</tr>
							<? endforeach; ?>
						</table>
						<center><input class="btn btn-default btn-sm" id = "submit_guardar" type = "submit" value="Guardar entregas" onClick=""/><a href="./registrarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>
					</form>
					
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>Registro de asistencia</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de entregas ha sido guardado <strong>exitosamente</strong>
					</div>
					
					<center><a href="./registrarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>

				</div>
			<? }?> 
		<?
			else:
				include(WEB_PATH."denegado.php");
			endif;
		?>
	<div class="panel-footer">
			<?if (isset($_SESSION["userName"])): ?>
				Usuario : <?=$_SESSION["userName"]?>  
			<? endif; ?>
		</div>
	</body>
</html>