<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = array();
	// cargar los posibles grupos
	$grupos = array();

	if(isset($_SESSION["role"]) && $_SESSION['role']=="ADMIN")
	{
		// cargar los posibles cursos
		$cursos = $contenedor->get_curso_collection();
		// cargar los posibles grupos
		$grupos = $contenedor->get_grupo_collection();	
	}
	else
	{
		$username = $_SESSION['userName'];
		print_variable("usuario para filtrar cursos", $username);
		//paso 1: mirar que cursos se les dejan disponibles
		$cursos = $helper->darCursosAutorizados($username, $contenedor->get_curso_collection());

		//paso 2: basado en los cursos, mirar que grupos se les dejan disponibles
		$grupos = $helper->darGruposAutorizados($username, $contenedor->get_curso_collection());
	}
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
		$actividad =new actividad($_REQUEST['combo_actividad']);
		$actividad->load();

		//traer las actividades que corresponden a ese curso y esa semana
	}
	//accion de guardar 
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		/*
			tomar los elementos del request
		
	    */
	    $semana = $_REQUEST['hidden_semana'];
	    $seccion = new seccion($_REQUEST['hidden_seccion']); $seccion->load();
	    
	    $calificaciones = array();

	    
	    $registradapor = $_SESSION['userName'];
	    
	    $helper->guardarEntregas($estudiantes, $actividades, $entregas, $semana, $seccion, $registradapor, $observaciones, $calificaciones);
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registro masivo de entregas</title>
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
					
					<h4>Registro masivo de entregas</h4>
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "generar" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Seleccione el grupo: 
								</th>
								<th>
									Seleccione el curso: 
								</th>
								
								<th>
									Seleccione la semana: 
								</th>

								<th>
									Seleccione la actividad: 
								</th>
							</tr>
							<tr>
								<td>
									<select class="form-control" name = "combo_grupo" id="combo_grupo">
										<? foreach($grupos as $grupo): ?>
						  					<option value="<?= $grupo->get_idgrupo() ?>" ><?= eecho ($grupo->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
								<td>
									<select class="form-control" name = "combo_curso" id="combo_curso"
										onchange="ajaxRequest('contenedor_combo_actividad','darActividadesPorCursoSemana', '&idcurso='+document.getElementById('combo_curso').value+'&numerosemana='+ document.getElementById('combo_semana').value);"
									>
										<? 
											$cursosel = array_values($cursos)[0];
											foreach($cursos as $curso): 
										?>
						  					<option value="<?= $curso->get_idcurso() ?>"  ><?= eecho ($curso->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
								<td>
									<select class="form-control" name = "combo_semana" id="combo_semana"
										onchange="ajaxRequest('contenedor_combo_actividad','darActividadesPorCursoSemana', '&idcurso='+document.getElementById('combo_curso').value+'&numerosemana='+ document.getElementById('combo_semana').value);"
									>
										<? 
											$semanasel = 0;
											for ( $sem = 0; $sem < 17; $sem++ ): 
										?>
						  					<option value="<?= $sem ?>" ><?= eecho ("Semana : ".$sem) ?></option>
						  				<? endfor; ?>
									</select>
								</td>
								<td id="contenedor_combo_actividad">
									<script type="text/javascript">
										ajaxRequest('contenedor_combo_actividad','darActividadesPorCursoSemana', '&idcurso=<?=$cursosel->get_idcurso()?>&numerosemana=<?=$semanasel ?>');
									</script>
								</td>
							</tr>
							<tr>
								
								<td colspan= "4">
									<center>
										<input class="btn btn-default btn-sm" id = "submit_generar" type = "submit" value="Importar planilla" onClick="document.getElementById('action').value='generar'; "/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./importarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					<h4>Registro masivo de entregas</h4>
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
							<th>
								<span class="glyphicon glyphicon-time"></span> Actividad
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
							<td>
								
								<small><? eecho ($actividad->get_nombre());?></small>
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
						<input type = "hidden" name= "hidden_actividad" id= "hidden_actividad" value = "<?=$_REQUEST['combo_actividad']?>" />
						<table class="table table-hover">	
							<tr>
								<th colspan = "3"><h4>Lista de calificaciones</h4></th>	
							</tr>
							<tr>
								<td colspan = "3">
									<p>
										<small>Para ingresar las notas descargue el archivo de notas de moodle y pegue en el siguiente campo un texto con el siguiente formato: [correo];[nota] </small>
										<div class="well">al.guien@uniandes.edu.co;2,5<br>
										pe-pito@uniandes.edu.co;3<br>
										yl.cacais@uniandes.edu.co;-<br>
										</div>
									</p>
								</td>	
							</tr>
							<tr>
								<td align = "center">
									<textarea 
										style="font-size: 10px;" 
										rows="20" 
										cols="100" 
										name="text_notas" 
										id="text_notas" 
									></textarea>
								</td>
							</tr>
						</table>
						<center>
							<input 
								class="btn btn-default btn-sm" 
								id = "submit_guardar" 
								type = "submit" 
								value="Cargar notas" 
							/>
							<a 
								href="./importarEntrega.php" 
								class="btn btn-default btn-sm"
							>Volver</a>
						</center>
					</form>
					<!--button onClick="copiarMatrices();">Prueba</button-->
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>Registro de asistencia</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de entregas ha sido guardado <strong>exitosamente</strong>
					</div>
					<center><a href="./importarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>
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