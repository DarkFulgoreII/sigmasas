<?
	session_start();
	require_once("../config.php");
	
	// cargar los posibles grupos
	$grupos = array();
	$grupos = $contenedor->get_grupo_collection();	
	
	// cargar los cursos
	$cursos = array();
	$cursos = $contenedor->get_curso_collection();
	
	print_recursive("REQUEST", $_REQUEST);
	//print_recursive("ESTUDIANTES", $estudiantes);

	validar_referer($_SESSION['serverurl']);
	

	//accion de generar - debe revisar primero si ya habían registros y debe cargarlos

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "verplanilla")
	{
		/*
			[action] => verplanilla
		    [combo_curso] => 1
		    [combo_grupo] => 1
		    [combo_rubricas] => 1
		*/
		$curso = new curso($_REQUEST['combo_curso']); $curso->load();
		$grupo = new grupo($_REQUEST['combo_grupo']); $grupo->load();
		$rubrica = new rubrica ($_REQUEST['combo_rubricas']); $rubrica->load();

		//cargar estudiantes del grupo
		$estudiantes = array();
		$estudiantes = $grupo->get_estudiante_collection();
	}
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "calificarrubrica")
	{
		/*
			[action] => calificarrubrica
		    [idestudiante] => 241
		    [idrubrica] => 1
		    [idgrupo] => 1
		    [idcurso] => 1
		*/
		$curso = new curso($_REQUEST['idcurso']); $curso->load();
		$grupo = new grupo($_REQUEST['idgrupo']); $grupo->load();
		$rubrica = new rubrica ($_REQUEST['idrubrica']); $rubrica->load();
		$estudiante = new estudiante ($_REQUEST['idestudiante']); $estudiante->load();

	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registrar prueba</title>
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
					
					<h4>Seleccione la prueba</h4>
					<form id = "frm_verregistros" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "verplanilla" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Curso: 
								</th>
								<td>
									<select 
										class="form-control" 
										name = "combo_curso" 
										id="combo_curso"
										onchange="ajaxRequest('contenedor_combo_prueba','darPruebasPorCurso', '&idcurso='+document.getElementById('combo_curso').value );"
									>
										<? 
											$cursosel = array_values($cursos)[0];
											foreach($cursos as $curso):
										?>
						  					<option value="<?= $curso->get_idcurso() ?>" ><?= eecho ($curso->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
							</tr>
							<tr>
								<th>
									Grupo: 
								</th>
								<td>
									<select 
										class="form-control" 
										name = "combo_grupo" 
										id="combo_grupo"
									>
										<? 
											$gruposel = array_values($grupos)[0];
											foreach($grupos as $grupo):
										?>
						  					<option value="<?= $grupo->get_idgrupo() ?>" ><?= eecho ($grupo->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
							</tr>
							<tr>
								<th>
									Prueba: 
								</th>
								<td id="contenedor_combo_prueba">
									<script type="text/javascript">
										ajaxRequest('contenedor_combo_prueba','darPruebasPorCurso', '&idcurso=<?=$cursosel->get_idcurso()?>');
									</script>
								</td>
							</tr>
							<tr>
								<td colspan= "4">
									<center>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_verplanilla" 
											type = "submit" 
											value="Ver planilla de calificaciones" 
											onClick="
											if(document.getElementById('combo_rubricas').length == 0)
											{
												alert('No hay una prueba seleccionada');
												return false;
											} 
											document.getElementById('action').value='verplanilla';"
										/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center>
						<a 
							href="./registrarPrueba.php" 
							class="btn btn-default btn-sm"
						>Volver</a>
					</center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "verplanilla") { ?>
				<div class="well" >
					
					<h4>Planilla de calificaciones</h4>
					<table class="table table-bordered" >
						<tr>
							<th>
								Curso: 
							</th>
							<th>
								Grupo: 
							</th>
							<th>
								Prueba: 
							</th>
						</tr>
						<tr>
							<td>
								<?eecho($curso->get_nombre());?>
							</td>
							<td>
								<?eecho($grupo->get_nombre());?>
							</td>
							<td>
								<?eecho($rubrica->get_nombre());?>
							</td>
						</tr>
						
						<tr>
							<td colspan= "3">
								<table class="table table-hover">	
									<tr>
										<th><h5><strong>Código Uniandes</strong></h5></th>
										<th><h5><strong>Nombres</strong></h5></th>
										<th><h5><strong>Calificación Actual</strong></h5></th>
										<th><h5><strong>Acciones</strong></h5></th>
									</tr>
									<? foreach($estudiantes as $estudiante ): ?>
										<tr>
											<td><small><?= $estudiante->get_codigouniandes()?></small></td>
											<td><small><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?> <?= $estudiante->get_nombres() ?> <?if($estudiante->get_desactivado()==1):?>(Retirado)<?endif;?></small></td>
											<td><small>(Sin calificar)</small></td>
											<td>
												<a 
												class="btn btn-primary btn-xs" 
												href = "./registrarPrueba.php?action=calificarrubrica&idestudiante=<?=$estudiante->get_idestudiante()?>&idrubrica=<?=$rubrica->get_idrubrica()?>&idgrupo=<?=$grupo->get_idgrupo()?>&idcurso=<?=$curso->get_idcurso()?>"
												>Calificar</a>
											</td>
											<td>
												<a 
												class="btn btn-danger btn-xs" 
												href = "./registrarPrueba.php?action=limpiarrubrica&idestudiante=<?=$estudiante->get_idestudiante()?>&idrubrica=<?=$rubrica->get_idrubrica()?>&idgrupo=<?=$grupo->get_idgrupo()?>&idcurso=<?=$curso->get_idcurso()?>"
												>Limpiar</a>
											</td>
										</tr>
									<? endforeach;?>
								</table>
							</td>
						</tr>
						
					</table>
				
					<center>
						<a 
							href="./verAcompanamiento.php" 
							class="btn btn-default btn-sm"
						>Volver</a>
					</center>
				</div>	
			
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "calificarrubrica") { ?>
				<div class="well" >
					
					<h4>Calificar prueba de estudiante</h4>
					<table class="table table-bordered" >
						<tr>
							<th>
								Curso: 
							</th>
							<th>
								Grupo: 
							</th>
							<th>
								Prueba: 
							</th>
							<th>
								Estudiante: 
							</th>
						</tr>
						<tr>
							<td>
								<?eecho($curso->get_nombre());?>
							</td>
							<td>
								<?eecho($grupo->get_nombre());?>
							</td>
							<td>
								<?eecho($rubrica->get_nombre());?>
							</td>
							<td>
								<? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?> <?= $estudiante->get_nombres() ?> <?if($estudiante->get_desactivado()==1):?>(Retirado)<?endif;?>
							</td>
						</tr>
						
						<tr>
							<td colspan= "3">
								<table class="table table-hover">	
									<tr>
										<th colspan = "2"><h5><strong>Criterio</strong></h5></th>
										<th><h5><strong>Competencias</strong></h5></th>
										<th><h5><strong>Niveles</strong></h5></th>
										<th><h5><strong>Calificacion</strong></h5></th>
										<th><h5><strong>Comentario</strong></h5></th>
									</tr>
									<? foreach($rubrica->get_criterio_collection() as $criterio ): ?>
										<tr>
											<td><small><? eecho($criterio->get_nombre());?></small></td>
											<td><small><? eecho($criterio->get_descripcion());?></small></td>
											<td><small>
												<? foreach($criterio->get_competencia_collection() as $competencia ): ?>
													$strcompetencias .= $competencia->get_nombre().",";	
												<? endforeach;?>
												<?
													$strcompetencias = preg_replace('/,$/', ' ', $strcompetencias);
													eecho($strcompetencias);
												?>

											</small></td>
											<td></td>
											<td></td>
										</tr>
									<? endforeach;?>
								</table>
							</td>
						</tr>
						
					</table>
				
					<center>
						<a 
							href="./verAcompanamiento.php" 
							class="btn btn-default btn-sm"
						>Volver</a>
					</center>
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