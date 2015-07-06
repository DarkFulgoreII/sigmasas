<?
	session_start();
	require_once("../config.php");
	
	// cargar los posibles grupos
	$grupos = array();
	$grupos = $contenedor->get_grupo_collection();	
	
	// cargar los tipos de acompañamiento

	$tiposacompanamiento = array();
	$tiposacompanamiento = $contenedor->get_tipoacompanamiento_collection();

	// cargar categorias 
	$categorias = array();
	$categorias = $contenedor->get_categoria_collection();
	$categorias = $helper->ordenarCategorias($categorias);

	//print_recursive("tiposacompanamiento", $tiposacompanamiento);
	//print_recursive("categorias", $categorias);
	
	print_recursive("REQUEST", $_REQUEST);
	//print_recursive("ESTUDIANTES", $estudiantes);

	validar_referer($_SESSION['serverurl']);
	

	//accion de generar - debe revisar primero si ya habían registros y debe cargarlos

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		/*
		[action] => guardar
	    [hidden_fecha] => 2015-06-24
	    [combo_grupo] => 1
	    [combo_estudiante] => 13
	    [combo_tipoacompanamiento] => 1
	    [checkbox_aspecto] => Array
	        (
	            [2] => on
	            [8] => on
	            [11] => on
	            [5] => on
	        )

	    [text_asunto] => Descripcion
	    [text_comentario] => Acuerdos
		*/
		$fecha = $_REQUEST['hidden_fecha'];
		
		$estudiante = new estudiante($_REQUEST['combo_estudiante']); $estudiante->load();
		$tipoacompanamiento = new tipoacompanamiento($_REQUEST['combo_tipoacompanamiento']); $tipoacompanamiento->load();
		$aspectos = array();
		if(isset($_REQUEST['checkbox_aspecto'])) $aspectos = $_REQUEST['checkbox_aspecto'];
		$asunto = $_REQUEST['text_asunto'];
		$comentario = $_REQUEST['text_comentario'];
		$registradapor = $_SESSION['userName'];
		$helper->guardarNuevoAcompanamiento($registradapor,$fecha, $estudiante, $tipoacompanamiento, $aspectos, $asunto, $comentario);
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Crear registro de acompañamiento</title>
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
					
					<h4>Crear registro de acompañamiento</h4>
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_fecha" id= "hidden_fecha" value = "vacio" />

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
								<th>
									Fecha: 
								</th>
								<td id="contenedor_combo_estudiante">
									<?
										putCalendarInput("calendar_fecha");	
									?>
								</td>
							</tr>
							<tr>
								<th>
									Tipo de cita: 
								</th>
								<td>
									<select 
										class="form-control" 
										name = "combo_tipoacompanamiento" 
										id="combo_tipoacompanamiento"
									>
										<? foreach($tiposacompanamiento as $tipo): ?>
						  					<option value="<?= $tipo->get_idtipoacompanamiento() ?>" ><?= eecho ($tipo->get_nombre()) ?></option>
						  				<? endforeach; ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<?foreach ($categorias as $categoria ) :?>
										<div class="panel panel-default">
										 	<div class="panel-heading">
										 		<strong>
										 			<? eecho ($categoria->get_nombre()); ?>
										 		</strong>
										 	</div>
										  	<div class="panel-body row">
										  		<?foreach($categoria->get_aspecto_collection() as $aspecto):?>
											  		<div class="col-sm-4">
												  		<input 
												  			type="checkbox"
												  			id="checkbox_aspecto[<?=$aspecto->get_idaspecto()?>]"
												  			name="checkbox_aspecto[<?=$aspecto->get_idaspecto()?>]"
												  		>
												  			<? eecho ($aspecto->get_nombre());?>
												  		</input>
												  	</div>
											  	<? endforeach; ?>
										  	</div>
										</div>
									<? endforeach; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="panel panel-default">
									 	<div class="panel-heading">
									 		<strong>Descripción / asunto</strong>
									 	</div>
									</div>
									<div class="panel-body">
										<center>
											<textarea 
												style="font-size: 10px;" 
												rows="6" 
												cols="100" 
												name="text_asunto" 
												id="text_asunto" 
											></textarea>
										</center>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="panel panel-default">
									 	<div class="panel-heading">
									 		<strong>Acuerdos, compromisos y acciones realizadas</strong>
									 	</div>
									</div>
									<div class="panel-body">
										<center>
											<textarea 
												style="font-size: 10px;" 
												rows="6" 
												cols="100" 
												name="text_comentario" 
												id="text_comentario" 
											></textarea>
										</center>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan= "4">
									<center>
										<input 
											class="btn btn-default btn-sm" 
											id = "submit_guardar" 
											type = "submit" 
											value="Guardar" 
											onClick="document.getElementById('action').value='guardar'; 
											document.getElementById('hidden_fecha').value=$('#calendar_fecha').jqxDateTimeInput('getText');"
										/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./registrarEntrega.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>Registro de acompañamiento</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    El registro de acompañamiento ha sido guardado <strong>exitosamente</strong>
					</div>
					<center><a href="./registrarAcompanamiento.php" class="btn btn-default btn-sm">Volver</a></center>
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