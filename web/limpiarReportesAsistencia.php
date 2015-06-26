<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = $contenedor->get_curso_collection();
	// cargar los posibles grupos
	$grupos = $contenedor->get_grupo_collection();
	//cargar bloques
	$bloques_totales = $helper->ordenarBloques($contenedor->get_bloque_collection(), false);
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
		
		//se traen las asistencias de cada estudiante de la seccion en este bloque y fecha
		$asistencias =array();
		$fechas = array();
		$bloques = array();
		$asistenciasagrupadas = array();

		
		foreach ($estudiantes as  $estudiante) 
		{
			$asistenciaestudiante =  $helper->darAsistencias_por_estudianteSeccion($estudiante, $seccion);
			$asistencias[$estudiante->get_idestudiante()] =$asistenciaestudiante;
			 
			foreach ($asistenciaestudiante as $fecha => $asistencias_fecha) 
			{
				$fechas[$fecha] = $fecha;
				foreach ($asistencias_fecha as $bloque => $asistencia_fecha_bloque) 
				{
					$bloques[$bloque] = $bloque;
					$sesionesvalidas[$fecha."__".$bloque]=$fecha."__".$bloque;

					$asistenciasagrupadas[$fecha."__".$bloque][$estudiante->get_idestudiante()]=$asistencia_fecha_bloque;
				}
			}
			
		}
		print_recursive("fechas", $fechas);
		print_recursive("asistenciasagrupadas", $asistenciasagrupadas);
		print_recursive("sesiones_validas", $sesionesvalidas);
		//print_recursive ("asistencias", $asistencias);
	}

	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "limpiar")
	{
		//cargar los estudiantes de la seccion
		$curso = new curso ();
		$curso->set_idcurso ($_REQUEST['hidden_curso']);
		$curso->load();

		$grupo = new grupo();
		$grupo->set_idgrupo($_REQUEST['hidden_grupo']);
		$grupo->load();

		$seccion= $helper->darSeccion_por_grupoCurso($curso, $grupo);
		
		$estudiantes = array();
		if($seccion != false)
		{
			$estudiantes = $seccion ->get_estudiante_collection();
			$estudiantes = $helper ->ordenarEstudiantes($estudiantes);
		}
		
		//se traen las asistencias de cada estudiante de la seccion en este bloque y fecha
		$asistencias =array();
		$fechas = array();
		$bloques = array();
		$asistenciasagrupadas = array();

		
		foreach ($estudiantes as  $estudiante) 
		{
			$asistenciaestudiante =  $helper->darAsistencias_por_estudianteSeccion($estudiante, $seccion);
			$asistencias[$estudiante->get_idestudiante()] =$asistenciaestudiante;
			 
			foreach ($asistenciaestudiante as $fecha => $asistencias_fecha) 
			{
				$fechas[$fecha] = $fecha;
				foreach ($asistencias_fecha as $bloque => $asistencia_fecha_bloque) 
				{
					$bloques[$bloque] = $bloque;
					$sesionesvalidas[$fecha."__".$bloque]=$fecha."__".$bloque;

					$asistenciasagrupadas[$fecha."__".$bloque][$estudiante->get_idestudiante()]=$asistencia_fecha_bloque;
				}
			}
			
		}

		$paquete_modificar = $_REQUEST['hidden_paquete'];
		$fecha_modificar = explode("__",$paquete_modificar)[0];
		$idbloque_modificar = explode("__",$paquete_modificar)[1];
		$bloque_modificar = new bloque($idbloque_modificar); $bloque_modificar->load();


	}
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "borrar")
	{
		//cargar los estudiantes de la seccion
		$curso = new curso ();
		$curso->set_idcurso ($_REQUEST['hidden_curso']);
		$curso->load();

		$grupo = new grupo();
		$grupo->set_idgrupo($_REQUEST['hidden_grupo']);
		$grupo->load();

		$seccion= $helper->darSeccion_por_grupoCurso($curso, $grupo);
		
		$estudiantes = array();
		if($seccion != false)
		{
			$estudiantes = $seccion ->get_estudiante_collection();
			$estudiantes = $helper ->ordenarEstudiantes($estudiantes);
		}
		
		//se traen las asistencias de cada estudiante de la seccion en este bloque y fecha
		$asistencias =array();
		$fechas = array();
		$bloques = array();
		$asistenciasagrupadas = array();

		
		foreach ($estudiantes as  $estudiante) 
		{
			$asistenciaestudiante =  $helper->darAsistencias_por_estudianteSeccion($estudiante, $seccion);
			$asistencias[$estudiante->get_idestudiante()] =$asistenciaestudiante;
			 
			foreach ($asistenciaestudiante as $fecha => $asistencias_fecha) 
			{
				$fechas[$fecha] = $fecha;
				foreach ($asistencias_fecha as $bloque => $asistencia_fecha_bloque) 
				{
					$bloques[$bloque] = $bloque;
					$sesionesvalidas[$fecha."__".$bloque]=$fecha."__".$bloque;

					$asistenciasagrupadas[$fecha."__".$bloque][$estudiante->get_idestudiante()]=$asistencia_fecha_bloque;
				}
			}
			
		}

		$paquete_modificar = $_REQUEST['hidden_paquete'];
		$fecha_modificar = explode("__",$paquete_modificar)[0];
		$idbloque_modificar = explode("__",$paquete_modificar)[1];
		$bloque_modificar = new bloque($idbloque_modificar); $bloque_modificar->load();

		print_recursive("eliminacion", count($asistenciasagrupadas[$paquete_modificar]));

		$helper->eliminarAsistencias ($asistenciasagrupadas[$paquete_modificar]);
	}
	
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Limpiar reportes de asistencia</title>
		<?
			include_javascript();
		?>
	</head>
	<body>
		<?include("../inc/header.php");?>
		
		<?include ("../inc/menu.php");?>

		<? if(isset($_SESSION["userName"])): ?>
			<? if(!isset($_REQUEST["action"])){ ?>
				<div class="well" >
					<h4>Limpiar reportes de asistencia</h4>
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
							</tr>
							<tr>
								
								<td colspan= "4">
									<center>
										<input class="btn btn-default btn-sm" id = "submit_generar" type = "submit" value="Mostrar registros" onClick="document.getElementById('action').value='generar'; "/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./limpiarReportesAsistencia.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					
					<h4>Asistencia por grupos</h4>
					<table class="table table-bordered">
						<tr>
							<th>
								 <span class="glyphicon glyphicon-book"></span> Curso
							</th>
							<th>
								 <span class="glyphicon glyphicon-user"></span> Grupo
							</th>
						</tr>
						<tr>
							<td>
								<small><? eecho($curso->get_nombre());?></small>
							</td>
							
							<td>
								<small><? eecho($seccion->get_descripcion()." CRN: ".$seccion->get_crn()); ?></small>
							</td>
						</tr>
					</table>
				</div>
				<div class="well">
					<form id = "frm_modificar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "vacio" />
						<input type = "hidden" name= "hidden_curso" id= "hidden_curso" value = "<?=$_REQUEST['combo_curso']?>" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<input type = "hidden" name= "hidden_paquete" id= "hidden_paquete" value = "vacio" />
						<table class="table table-hover">
							<tr>
								<th><h4>Fecha</h4></th>
								<th><h4>Bloque</h4></th>
								<th><h4>Registros</h4></th>
								<th><h4>Limpiar</h4></th>
							</tr>
							<tr>
								<?
									foreach ($fechas as $fecha):
										foreach($bloques as $bloque):
											$bloqueobjeto = new bloque($bloque);
											$bloqueobjeto->load();
								?>
											<? if(isset($sesionesvalidas[$fecha."__".$bloque])): ?>
												<tr>
													<td>
														<? eecho ($fecha) ?>
													</td>
													<td>
														<small> <? eecho ($bloqueobjeto->get_descripcion()); ?></small>
													</td>
													
													<td>
														<? echo count($asistenciasagrupadas[$fecha."__".$bloque]); ?>
													</td>
													<td>
														<input 
														class="btn btn-danger btn-sm" 
														id = "submit_modificar" 
														type = "submit" 
														value="Eliminar registros" 
														onClick="document.getElementById('action').value='limpiar'; document.getElementById('hidden_paquete').value='<?= $fecha."__".$bloque ?>';"
														> 
														</input>
													</td>
												</tr>
											
											<? endif; ?>
								<?
										endforeach;
									endforeach;
								?>
							</tr>
						</table>
						<center>
							<a href="#" class="btn btn-default btn-sm" id = "submit_imprimir" onClick="window.print();">
      							<span class="glyphicon glyphicon-print"></span> Imprimir 
    						</a>
							<a href="./moverReportesAsistencia.php" class="btn btn-default btn-sm">Volver</a>
						</center>
					</form>
					
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "limpiar") { ?>
				<div class="well">
					<form id = "frm_guardar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">

						<div class="alert alert-danger">
						  <h4>¿Está usted <strong>absolutamente seguro </strong>de querer <strong>borrar</strong> los siguientes registros de asistencia?</h4>
						</div>

						
						<input type = "hidden" name= "action" id= "action" value = "vacio" />
						<input type = "hidden" name= "hidden_curso" id= "hidden_curso" value = "<?=$_REQUEST['hidden_curso']?>" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['hidden_grupo']?>" />
						<input type = "hidden" name= "hidden_paquete" id= "hidden_paquete" value = "<?=$_REQUEST['hidden_paquete']?>" />
						<input type = "hidden" name= "hidden_fecha_nueva" id= "hidden_fecha_nueva" value = "vacio" />
						<table class="table table-bordered">

							<tr>
								<th>
									 <span class="glyphicon glyphicon-book"></span> Curso
								</th>
								<th>
									 <span class="glyphicon glyphicon-user"></span> Grupo
								</th>
								<th>
									 <span class="glyphicon glyphicon-calendar"></span> Fecha actual
								</th>
								<th>
									 <span class="glyphicon glyphicon-time"></span> Bloque actual
								</th>
								
								<th>
									 <span class="glyphicon glyphicon-remove"></span> Borrar
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
									<small><?= $fecha_modificar ?></small>
								</td>
								<td>
									<small><? eecho ($bloque_modificar->get_descripcion());  ?></small>
								</td>
								<td>
									<input 
									class="btn btn-danger btn-sm" 
									id = "submit_borrar" 
									type = "submit" 
									value="¡Borrar Registros!" 
									onClick="document.getElementById('action').value='borrar'; document.getElementById('hidden_fecha_nueva').value=$('#calendar_fecha_nueva').jqxDateTimeInput('getText');"
									> 
									</input>
								</td>
							</tr>
						</table>
					<form>
						<center>
							<a class="btn btn-default btn-xs" href="./limpiarReportesAsistencia.php">Volver</a>
						</center>

				</div>
			

			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "borrar") { ?>
				<div class="well">
					
					<h4>Eliminación de asistencias</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de asistencia ha sido <strong>eliminado exitosamente</strong>
					</div>
					
					<center><a href="./limpiarReportesAsistencia.php" class="btn btn-default btn-sm">Volver</a></center>

				</div>
			<? }?>
		<?
			else:
				include(WEB_PATH."denegado.php");
			endif;
		?>
		<?include("../inc/footer.php");?>
	</body>
</html>