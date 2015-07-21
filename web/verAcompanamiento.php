<?
	session_start();
	require_once("../config.php");
	
	// cargar los posibles grupos
	$grupos = array();
	$grupos = $contenedor->get_grupo_collection();	
	
	
	print_recursive("REQUEST", $_REQUEST);
	//print_recursive("ESTUDIANTES", $estudiantes);

	validar_referer($_SESSION['serverurl']);
	

	//accion de generar - debe revisar primero si ya habían registros y debe cargarlos

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "verregistros")
	{
		/*
			[action] => verregistros
		    [combo_grupo] => 1
		    [combo_estudiante] => 13
		*/
		$estudiante = new estudiante($_REQUEST['combo_estudiante']); $estudiante->load();
		$grupo = new grupo ($_REQUEST['combo_grupo']); $grupo->load();
		$acompanamientos = array();
		$acompanamientos=$helper->darAcompanamientosPorEstudiante($estudiante->get_idestudiante());

		print_variable("acompanamientos", count($acompanamientos));
		$registradapor = $_SESSION['userName'];
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Ver registros de acompañamiento</title>
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
					
					<h4>Ver registros de acompañamiento</h4>
					<form id = "frm_verregistros" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						

						<table class="table table-bordered" >
							<tr>
								<th>
									Grupo: 
								</th>
								<td>
									<select 
										class="form-control" 
										name = "combo_grupo" 
										id="combo_grupo"
										onchange="ajaxRequest('contenedor_combo_estudiante','darEstudiantesPorGrupo', '&idgrupo='+document.getElementById('combo_grupo').value );"
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
									Estudiante: 
								</th>
								<td id="contenedor_combo_estudiante">
									<script type="text/javascript">
										ajaxRequest('contenedor_combo_estudiante','darEstudiantesPorGrupo', '&idgrupo=<?=$gruposel->get_idgrupo()?>');
									</script>
								</td>
							</tr>
							<tr>
								<td colspan= "4">
									<center>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_verregistros" 
											type = "submit" 
											value="Ver Registros" 
											onClick="document.getElementById('action').value='verregistros';"
										/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center>
						<a 
							href="./verAcompanamiento.php" 
							class="btn btn-default btn-sm"
						>Volver</a>
					</center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "verregistros") { ?>
				<div class="well" >
					
					<h4>Ver registros de acompañamiento</h4>
					<table class="table table-bordered" >
						<tr>
							<th>
								Grupo: 
							</th>
							<th>
								Código: 
							</th>
							<th>
								Estudiante: 
							</th>
						</tr>
						<tr>
							<td>
								<?eecho($grupo->get_nombre());?>
							</td>
							<td>
								<?eecho($estudiante->get_codigouniandes());?>
							</td>
							<td>
								<? eecho ($estudiante->get_nombres()." ".$estudiante->get_apellido1()." ".$estudiante->get_apellido2() ) ; ?>
							</td>
						</tr>
						<tr>
							<th colspan= "3">
								Registros de acompañamiento 
							</th>
						</tr>
						<tr>
							<td colspan= "3">
								<table class="table table-hover">	
									<tr>
										<th><h5><strong>Fecha</strong></h5></th>
										<th><h5><strong>Tipo Acompañamiento</strong></h5></th>
										<th><h5><strong>Registrada por</strong></h5></th>
										<th><h5><strong>Descripción / asunto</strong></h5></th>
										<th><h5><strong>Acuerdos, compromisos y acciones realizadas</strong></h5></th>
										<th><h5><strong>Categorias y Aspectos</strong></h5></th>
										<th><h5><strong>Acciones</strong></h5></th>
									</tr>
									<? foreach($acompanamientos as $acompanamiento ): ?>
										<tr>
											<td><small><?=$acompanamiento->get_fecha()?></small></td>
											<td><small><? eecho($acompanamiento->get_tipoacompanamiento_element()->get_nombre()); ?></small></td>
											<td><small><?=$acompanamiento->get_registradapor()?></small></td>
											<td><font size ="1"><? eecho($acompanamiento->get_asunto()); ?></font></td>
											<td><font size ="1"><? eecho($acompanamiento->get_comentario()); ?></font></td>
											<td>
												<ul>
													<?foreach($acompanamiento->get_aspecto_collection() as $aspecto):?>
														<li>
															<font size ="1"><? eecho($aspecto->get_nombre()); ?></font>
														</li>
													<?endforeach;?>
												</ul>
											</td>
											<td>
												<a 
												class="btn btn-primary btn-xs" 
												href = "./registrarAcompanamiento.php?action=modificar&idestudiante=<?=$estudiante->get_idestudiante()?>&idacompanamiento=<?=$acompanamiento->get_idacompanamiento()?>"
												>Modificar</a>
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
			<? }?> 
		<?
			else:
				include(WEB_PATH."denegado.php");
			endif;
		?>
		<?include("../inc/footer.php");?>
	</body>
</html>