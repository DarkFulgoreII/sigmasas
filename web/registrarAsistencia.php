<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = array();
	// cargar los posibles grupos
	$grupos = array();

	//cargar bloques
	$bloques = $helper->ordenarBloques($contenedor->get_bloque_collection());

	if(isset($_SESSION["role"]) && $_SESSION['role']=="ADMIN")
	{
		$grupos = $contenedor->get_grupo_collection();
		$cursos = $contenedor->get_curso_collection();
	}
	else
	{
		//si el rol es monitor, es necesario revisar sus afiliaciones para saber que cursos mostrar
		$username = $_SESSION['userName'];
		print_variable("usuario para filtrar cursos", $username);
		//paso 1: mirar que cursos se les dejan disponibles
		$cursos = $helper->darCursosAutorizados($username, $contenedor->get_curso_collection());

		//paso 2: basado en los cursos, mirar que grupos se les dejan disponibles
		$grupos = $helper->darGruposAutorizados($username, $contenedor->get_curso_collection());
		
		//paso 3: filtrar bloques
		$bloques = $helper->filtrarBloquesAutorizados($cursos, $bloques);
	}

	
	//print_recursive("cursos", $cursos);
	//print_recursive("grupos", $grupos);
	print_recursive("REQUEST", $_REQUEST);
	print_recursive("SESSION", $_SESSION);
	validar_referer($_SESSION['serverurl']);
	//print_recursive("bloques", $bloques);

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
		
		$bloque = new bloque();
		$bloque->set_idbloque($_REQUEST['combo_bloque']);
		$bloque->load();

		$fecha = $_REQUEST['hidden_fecha'];

		//se traen las asistencias de cada estudiante de la seccion en este bloque y fecha
		$asistencias =array();
		
		foreach ($estudiantes as  $estudiante) 
		{
			$asistenciaestudiante =  $helper->darAsistencias_por_estudianteSeccionBloqueFecha($estudiante, $seccion, $bloque, $fecha);
			if($asistenciaestudiante!= false)
			{
				$asistencias[$estudiante->get_idestudiante()] =$asistenciaestudiante;
			}
		}
		//print_recursive("asistencias antiguas", $asistencias);
		
	}
	//accion de guardar 
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		/*tomar los elementos del request
		[action] => guardar
	    [hidden_fecha] => 2015-05-21
	    [hidden_bloque] => 1
	    [hidden_curso] => 1
	    [hidden_grupo] => 1
	    [hidden_seccion] => 1
	    [estudiantes] => Array[pos]=idestudiante
	    [checkbox_asiste] => Array[idestudiante]=true
	    [checkbox_justifica] => Array[idestudiante]=true
	    */
	    $fecha = $_REQUEST['hidden_fecha'];
	    $bloque = new bloque($_REQUEST['hidden_bloque']); $bloque->load();
	    $seccion = new seccion($_REQUEST['hidden_seccion']); $seccion->load();
	    $estudiantes = $_REQUEST['estudiantes'];
	    $asistencias = array();
	    $justificaciones = array();
	    $observaciones = array();
	    if(isset($_REQUEST['checkbox_asiste'])) $asistencias = $_REQUEST['checkbox_asiste'];
	    if(isset($_REQUEST['checkbox_justifica'])) $justificaciones = $_REQUEST['checkbox_justifica'];
	    if(isset($_REQUEST['text_observaciones'])) $observaciones = $_REQUEST['text_observaciones'];
	    $registradapor = $_SESSION['userName'];
	    $helper->guardarAsistencias($estudiantes, $asistencias, $justificaciones, $fecha, $seccion, $bloque, $registradapor, $observaciones);
	}
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "imprimir")
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
		
		$bloque = new bloque();
		$bloque->set_idbloque($_REQUEST['combo_bloque']);
		$bloque->load();

		$fecha = $_REQUEST['hidden_fecha'];
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registrar asistencia</title>
		<?
			include_javascript();
		?>
	</head>
	<body>
		<? if((!isset($_REQUEST["action"]))||(isset($_REQUEST["action"]) && $_REQUEST["action"] != "imprimir")): ?>
			<?include("../inc/header.php");?>
		<?endif;?>
		
		<?if((!isset($_REQUEST["action"]))||(isset($_REQUEST["action"]) && $_REQUEST["action"] != "imprimir")) include ("../inc/menu.php");?>

		
		<? if(isset($_SESSION["userName"])): ?>
			<? if(!isset($_REQUEST["action"])){ ?>
				<div class="well" >
					<h4>Registro de asistencia</h4>
					<table class="table table-bordered table-condensed">
						<tr>
							<td>
								<small>
									Para hacer un registro de asistencia, es necesario especificar : 
									<ul>
										<li><strong>Curso</strong> al que se registrará asistencia</li>
										<li><strong>Grupo</strong> al que pertenecen los estudiantes</li>
										<li><strong>Fecha</strong> de la sesión (favor revisar con cuidado que la fecha sea correcta)</li>
										<li><strong>Bloque</strong> horario de la sesión</li>
									</ul> 
								</small>
							</td>	
							<td>
								<small>
									Los bloques horarios manejan las siguientes convenciones:
									<ul>
										<li><strong>PP:</strong> Clase presencial de precálculo (sábado)</li>
										<li><strong>PE:</strong> Clase presencial de español (sábado)</li>
										<li><strong>VU:</strong> Sesión de vida universitaria</li>
										<li><strong>MP:</strong> Monitoría de precálculo (lunes o viernes)</li>
										<li><strong>AE:</strong> Asesoría de español</li>
										<li><strong>CAP:</strong> Capacitaciones</li>
									</ul> 
									Por favor, es necesario revisar con cuidado el bloque horario, <br><strong> NO se debe utilizar un bloque que no corresponde al curso para el cual usted registra asistencia</strong>
								</small>
							</td>
						</tr>
					</table>
					
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "generar" />
						<input type = "hidden" name= "hidden_fecha" id= "hidden_fecha" value = "vacio" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Seleccione el curso: 
								</th>
								<th>
									Seleccione el grupo: 
								</th>
								<th>
									Seleccione la fecha: 
								</th>
								<th>
									Seleccione el bloque: 
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
									<?
										putCalendarInput("calendar_fecha");	
									?>
								</td>
								
								<td>
									<select class="form-control" name = "combo_bloque" id="combo_bloque">
										<? foreach($bloques as $bloque): ?>
						  					<option value="<?= $bloque->get_idbloque() ?>" ><?= eecho ($bloque->get_descripcion()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
							</tr>
							<tr>
								
								<td colspan= "4">
									<?
										$desactivarsubmit = "";
										if(count($cursos)==0 || count($bloques)==0 || count($grupos)==0)
										{
											$desactivarsubmit = " disabled ";
										}
									?>
									<center>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_generar" 
											type = "submit" 
											value="Llenar planilla" 
											onClick="document.getElementById('action').value='generar'; 
											document.getElementById('hidden_fecha').value=$('#calendar_fecha').jqxDateTimeInput('getText');"
											<?=$desactivarsubmit?>
										/>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_imprimir" 
											type = "submit" 
											value="Crear planilla para imprimir" 
											onClick="document.getElementById('action').value='imprimir'; 
											document.getElementById('hidden_fecha').value=$('#calendar_fecha').jqxDateTimeInput('getText');"
											<?=$desactivarsubmit?>
										/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./registrarAsistencia.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					
					<h4>Registro de asistencia</h4>
					
					<table class="table table-bordered">
						<tr>
							<th>
								 <span class="glyphicon glyphicon-book"></span> Curso
							</th>
							<th>
								 <span class="glyphicon glyphicon-user"></span> Grupo
							</th>
							<th>
								<span class="glyphicon glyphicon-calendar"></span> Fecha 
							</th>
							<th>
								<span class="glyphicon glyphicon-time"></span> Bloque
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
								<small><?=$_REQUEST['hidden_fecha']?></small>
							</td>
							
							<td>
								<small><? eecho ($bloque->get_descripcion());?></small>
							</td>
						</tr>
					</table>
				</div>
				<div class="well">
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_fecha" id= "hidden_fecha" value = "<?=$_REQUEST['hidden_fecha']?>" />
						<input type = "hidden" name= "hidden_bloque" id= "hidden_bloque" value = "<?=$_REQUEST['combo_bloque']?>" />
						<input type = "hidden" name= "hidden_curso" id= "hidden_curso" value = "<?=$_REQUEST['combo_curso']?>" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<input type = "hidden" name= "hidden_seccion" id= "hidden_seccion" value = "<?=$seccion->get_idseccion()?>" />
						<table class="table table-hover">	
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Apellidos</h4></th>
								<th><h4>Nombres</h4></th>
								<th><h4>Asiste</h4></th>
								<th><h4>Justificación</h4></th>
								<th><h4>Observaciones</h4></th>
							</tr>
							<? foreach($estudiantes as $estudiante):?>
								<tr>
									
									<td><small><?= $estudiante->get_codigouniandes() ?></small></td>
									<td><small><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></small></td>
									<td><small><?= $estudiante->get_nombres() ?> <?if($estudiante->get_desactivado()==1):?>(Retirado)<?endif;?></small></td>

									<?
										$activaasiste = "";
										$activajustifica = "";
										
										$claseasiste = "class='danger'";
										$clasejustifica = "class='danger'";
										if(isset ($asistencias[$estudiante->get_idestudiante()]))
										{
											if($asistencias[$estudiante->get_idestudiante()]->get_asiste()==1)
											{
												$claseasiste = "class='success'";
												$activaasiste="checked";	
											} 
											if($asistencias[$estudiante->get_idestudiante()]->get_justificacion()==1) 
											{
												$clasejustifica = "class='success'";
												$activajustifica="checked";
											}
										}
									?>
										<td <?= $claseasiste ?>><input type="checkbox" name="checkbox_asiste[<?= $estudiante->get_idestudiante() ?>]" id="checkbox_asiste[<?= $estudiante->get_idestudiante() ?>]"   <?= $activaasiste ?>  /> </td>
										<td <?= $clasejustifica ?>><input type="checkbox" name="checkbox_justifica[<?= $estudiante->get_idestudiante() ?>]" id="checkbox_justifica[<?= $estudiante->get_idestudiante() ?>]" <?= $activajustifica ?> /></td>
										<?
											if(isset ($asistencias[$estudiante->get_idestudiante()]))
											{
												$contenidoobservaciones = $asistencias[$estudiante->get_idestudiante()]->get_observaciones();
											}
											else
											{
												$contenidoobservaciones = "";
											}
										?>
										<td <?= $claseasiste ?>>
											<textarea rows="2" cols="50" name="text_observaciones[<?= $estudiante->get_idestudiante() ?>]" id="text_observaciones[<?= $estudiante->get_idestudiante() ?>]"><?=$contenidoobservaciones?></textarea>
										</td>
									<input type = "hidden" name= "estudiantes[] " id= "estudiantes[] " value = "<?= $estudiante->get_idestudiante()?>" />
								</tr>
							<? endforeach; ?>
						</table>
						<center><input class="btn btn-default btn-sm" id = "submit_guardar" type = "submit" value="Guardar asistencia" onClick=""/><a href="./registrarAsistencia.php" class="btn btn-default btn-sm">Volver</a></center>
					</form>
					
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "imprimir") { ?>
				<div class="well">
					
					<strong><font size="1">Programa Sigma - Registro de asistencia</font></strong>
					<table class="table table-bordered table-condensed">
						<tr>
							<td class="small">
								 <font size="1"> Curso: <? eecho($curso->get_nombre());?></font>
							</td>
							<td class="small">
								 <font size="1"> Grupo: <? eecho($seccion->get_descripcion()." CRN: ".$seccion->get_crn()); ?></font>
							</td>
							<td class="small">
								<font size="1"> Fecha : <?=$_REQUEST['hidden_fecha']?></font>
							</td class="small">
							<td class="small">
								<font size="1"> Bloque :<? eecho ($bloque->get_descripcion());?></font>
							</td>
						</tr>
					</table>
				
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<table class="table table-bordered table-condensed">	
							<tr>
								<td class="small"><font size="1"><strong>Código</strong></font></td>
								<td class="small"><font size="1"><strong>Apellidos</strong></font></td>
								<td class="small"><font size="1"><strong>Nombres</strong></font></td>
								<td class="small"><font size="1"><strong>Firma</strong></font></td>
								
							</tr>
							<? foreach($estudiantes as $estudiante):?>
								<tr>
									<td class="small"><font size="1"><?= $estudiante->get_codigouniandes() ?></font></td>
									<td class="small"><font size="1"><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></font></td>
									<td class="small"><font size="1"><?= $estudiante->get_nombres() ?></font></td>
									<td width="30%"></td>
								</tr>
							<? endforeach; ?>
							<tr border="1">
								<td colspan="2" class="small">
									<font size="1">Firma del responsable:</font>
								</td>
								<td colspan="2" >
									
								</td>
							</tr>
							
						</table>
						<center>
							<a href="#" class="btn btn-default btn-xs" id = "submit_imprimir" onClick="window.print();">
      							<span class="glyphicon glyphicon-print"></span> Imprimir 
    						</a>
							<a class="btn btn-default btn-xs" href="./registrarAsistencia.php">Volver</a>
						</center>
					</form>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					
					<h4>Registro de asistencia</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de asistencia ha sido guardado <strong>exitosamente</strong>
					</div>
					
					<center><a href="./registrarAsistencia.php" class="btn btn-default btn-sm">Volver</a></center>

				</div>
			<? }?> 
		<?
			else:
				include(WEB_PATH."denegado.php");
			endif;
		?>
		<? if(((!isset($_REQUEST["action"]))||(isset($_REQUEST["action"]) && $_REQUEST["action"] != "imprimir")) && isset($_SESSION["userName"])): ?>
			<?include("../inc/footer.php");?>
		<? endif; ?>
	</body>
</html>