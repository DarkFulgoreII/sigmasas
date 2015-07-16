<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = array();
	// cargar los posibles grupos
	$grupos = array();

	// cargar los posibles grupos
	$grupos = $contenedor->get_grupo_collection();	

	//cargar los tipos de acompañamiento
	$tiposacompanamiento = $contenedor->get_tipoacompanamiento_collection();

	//print_recursive("cursos", $cursos);
	//print_recursive("grupos", $grupos);
	print_recursive("REQUEST", $_REQUEST);
	print_recursive("SESSION", $_SESSION);

	validar_referer($_SESSION['serverurl']);
	
	//accion de generar - debe revisar primero si ya habían registros y debe cargarlos

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar")
	{
		$grupo = new grupo();
		$grupo->set_idgrupo($_REQUEST['combo_grupo']);
		$grupo->load();
		
		$estudiantes = array();
		$estudiantes = $helper->ordenarEstudiantes($grupo->get_estudiante_collection());
		
		$fecha = $_REQUEST['hidden_fecha'];
		$idtipoa = $_REQUEST['combo_tipoacompanamiento'];
		//traer las categorias y aspectos

		$tipoacompanamiento = new tipoacompanamiento($idtipoa); $tipoacompanamiento->load();
		$categorias = $tipoacompanamiento->get_categoria_collection();

	}
	//accion de guardar 
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		/*
		tomar los elementos del request
		[action] => guardar
	    [hidden_grupo] => idgrupo
	    [hidden_fecha] => 2015-06-26
	    [hidden_tipoacompanamiento] => idtipoacompanamiento
	    [checkbox_aspectos] => Array[idestudiante][idaspecto] = on
	    [combo_aspectos] => Array[idestudiante][idcategoria] = idaspecto
		[text_asunto] => Array[idestudiante]
		[text_observaciones] => Array[idestudiante]
		[guardar_acompanamiento] => Array[idestudiante] = on
		[estudiantes] => Array[pos] = idestudiante
	    */
	    
		$grupo = new grupo($_REQUEST['hidden_grupo']); $grupo->load() ;
		$aspectosmultiples = array();
		if(isset($_REQUEST['checkbox_aspectos'])) $aspectosmultiples = $_REQUEST['checkbox_aspectos'];
		$aspectossimples = $_REQUEST['combo_aspectos'];
		$asuntos = $_REQUEST['text_asunto'];
		$comentarios = $_REQUEST['text_observaciones'];
		$guardar = $_REQUEST['guardar_acompanamiento'];
		$fecha = $_REQUEST['hidden_fecha'];
		$tipoacompanamiento = new tipoacompanamiento($_REQUEST['hidden_tipoacompanamiento']);$tipoacompanamiento->load();

		$registradapor = $_SESSION['userName'];

		foreach ($guardar as $idestudiante => $valor_on) 
		{
			$estudiante = new estudiante ($idestudiante);$estudiante->load();
			$aspectos = $aspectosmultiples[$idestudiante];
			if (isset($aspectossimples[$idestudiante]))
			{
				foreach ($aspectossimples[$idestudiante] as $aspectocategoria) 
				{
					$aspectos[$aspectocategoria] = "on"; 	
				}	
			}
			$asunto = $asuntos[$idestudiante];
			$comentario = $comentarios[$idestudiante];
			$helper->guardarNuevoAcompanamiento($registradapor,$fecha, $estudiante, $tipoacompanamiento, $aspectos, $asunto, $comentario);	
		}
		
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registrar acompañamiento masivo</title>
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
					<h4>Registro de acompañamiento masivo</h4>
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "generar" />
						<input type = "hidden" name= "hidden_fecha" id= "hidden_fecha" value = "" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Seleccione el tipo de acompañamiento: 
								</th>
								<th>
									Seleccione el grupo: 
								</th>
								<th>
									Seleccione la fecha: 
								</th>
							</tr>
							<tr>
								<td>
									<select class="form-control" name = "combo_tipoacompanamiento" id="combo_tipoacompanamiento">
										<? foreach($tiposacompanamiento as $tipo): ?>
						  					<option value="<?= $tipo->get_idtipoacompanamiento() ?>"  ><?= eecho ($tipo->get_nombre()) ?></option>
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
									<? putCalendarInput("calendar_fecha"); ?>
								</td>
							</tr>
							<tr>
								<td colspan= "4">
									<center>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_generar" 
											type = "submit" 
											value="Llenar acompañamiento" 
											onClick="document.getElementById('action').value='generar';
											document.getElementById('hidden_fecha').value=$('#calendar_fecha').jqxDateTimeInput('getText');"
										/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./registrarAcompanamientoMasivo.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					<h4>Registro de acompañamiento</h4>
					<table class="table table-bordered">
						<tr>
							<th>
								 <span class="glyphicon glyphicon-book"></span> Tipo Acompañamiento
							</th>
							<th>
								 <span class="glyphicon glyphicon-user"></span> Grupo
							</th>
							<th>
								<span class="glyphicon glyphicon-calendar"></span> Fecha
							</th>
						</tr>
						<tr>
							<td>
								<small><? eecho($tipoacompanamiento->get_nombre());?></small>
							</td>
							<td>
								<small><? eecho($grupo->get_nombre()); ?></small>
							</td>
							<td>
								<small><? eecho ($fecha);?></small>
							</td>
						</tr>
					</table>
				</div>
				<div class="row-fluid">
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<input type = "hidden" name= "hidden_fecha" id= "hidden_fecha" value = "<?=$fecha?>" />
						<input type = "hidden" name= "hidden_tipoacompanamiento" id= "hidden_tipoacompanamiento" value = "<?=$_REQUEST['combo_tipoacompanamiento']?>" />
						<table class="table table-hover">	
							<tr>
								<th colspan = "2">Datos básicos</th>
								<th colspan="<?= count($categorias) ?>">Categorías</th>	
								<th colspan = "2">  Observaciones </th>
								<th> Guardar </th>
							</tr>
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Estudiante</h4></th>
								
								<?foreach ($categorias as $categoria ) :?>
									<th><h4><?eecho($categoria->get_nombre());?></h4></th>
								<?endforeach;?>
								<th><h4>Descripción / Caso</h4></th>
								<th><h4>Acciones tomadas</h4></th>
								<th></th>
							</tr>
							<? foreach($estudiantes as $estudiante):?>
								<tr>
									<td><font size="1"><?= $estudiante->get_codigouniandes() ?></font></td>
									<td>
										<font size="1">
											<? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?> <? eecho($estudiante->get_nombres()); ?> <?if($estudiante->get_desactivado()==1):?> (Retirado) <?endif;?>
										</font>
									</td>
									
									<?foreach ($categorias as $categoria ) :?>
										<?if($categoria->get_multiple()==1):?>
											<td>
												<table>
													<? foreach($categoria->get_aspecto_collection() as $aspecto): ?>
														<tr>
															<td>
																<font size="1">
																	<div class="checkbox">
																		<label>
																			<input 
																				type="checkbox" 
																				name="checkbox_aspectos[<?= $estudiante->get_idestudiante() ?>][<?=$aspecto->get_idaspecto()?>]" 
																				name="checkbox_aspectos[<?= $estudiante->get_idestudiante() ?>][<?=$aspecto->get_idaspecto()?>]" 
																				onClick="document.getElementById('guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]').checked = true;"
																			>
																				<?eecho($aspecto->get_nombre());?>
																			</input>
																		</label>
																	</div>
																</font>
															</td>
														</tr>
													<?endforeach;?>
												</table>
											</td>
										<?else: ?>
											<td>
												<select 
													class="form-control" 
													name = "combo_aspectos[<?= $estudiante->get_idestudiante() ?>][<?= $categoria->get_idcategoria() ?>]" 
													id="combo_aspectos[<?= $estudiante->get_idestudiante() ?>][<?= $categoria->get_idcategoria() ?>]"
													onClick="document.getElementById('guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]').checked = true;"
													style="font-size:9px;"
												>
													<? foreach($categoria->get_aspecto_collection() as $aspecto): ?>	
									  					<option value="<?= $aspecto->get_idaspecto() ?>"  ><?= eecho ($aspecto->get_nombre()) ?></option>
									  				<?endforeach;?>	
												</select>
											</td>
										<?endif;?>
									<?endforeach;?>
									<td>
										<textarea 
											rows="4" 
											cols="25" 
											name="text_asunto[<?= $estudiante->get_idestudiante() ?>]" 
											id="text_asunto[<?= $estudiante->get_idestudiante() ?>]"
											oninput="document.getElementById('guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]').checked = true;"
										></textarea>
									</td>
									<td>
										<textarea 
											rows="4" 
											cols="25" 
											name="text_observaciones[<?= $estudiante->get_idestudiante() ?>]" 
											id="text_observaciones[<?= $estudiante->get_idestudiante() ?>]"
											oninput="document.getElementById('guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]').checked = true;"
										></textarea>
									</td>
									<td>
										<div class="checkbox">
											<label>
												<input 
													type="checkbox" 
													name="guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]" 
													id="guardar_acompanamiento[<?= $estudiante->get_idestudiante() ?>]" 
												><font size = "1">Guardar</font></input>
											</label>
										</div>
									</td>
									<input type = "hidden" name= "estudiantes[] " id= "estudiantes[] " value = "<?= $estudiante->get_idestudiante()?>" />
								</tr>
							<? endforeach; ?>
						</table>
						
						<center>
							<input 
								class="btn btn-default btn-sm" 
								id = "submit_guardar" 
								type = "submit" 
								value="Guardar Registros de acompañamiento" 
							/>
							<a 
								href="./registrarAcompanamientoMasivo.php" 
								class="btn btn-default btn-sm"
							>Volver</a>
						</center>
					</form>
					<!--button onClick="copiarMatrices();">Prueba</button-->
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>Registro Acompañamiento </h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de acompañamiento ha sido guardado <strong>exitosamente</strong>
					</div>
					<center><a href="./registrarAcompanamientoMasivo.php" class="btn btn-default btn-sm">Volver</a></center>
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