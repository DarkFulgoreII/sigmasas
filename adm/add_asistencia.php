<?php
	session_start();
	require_once("../config.php");
	if(!isset($_REQUEST["action"]))
	{
		//accion por defecto - formulario para insertar un elemento
	}
	else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar")
	{
		//accion para agregar
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Crear asistencia</title>
		<?
			include_javascript();
		?>
	</head>
	<body>
		<?include("../inc/header.php");?>
		
		<?//include ("../inc/menu.php");?>

		<? if(isset($_SESSION["userName"])): ?>
			<? if(!isset($_REQUEST["action"])){ ?>
				<div class="well" >
					
					<h4>Crear asistencia</h4>
					<form id = "frm_agregar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						

						<table class="table table-bordered" >
							
								<!--simple attributes-->
								
									<tr>
										<th>
											asiste <!-- (tinyint) -->
										</th>
										<td>
											
												<select 
													class="form-control" 
													name = "tinyint_asiste" 
													id="tinyint_asiste"
												>
									  				<option value="0">Sí</option>
									  				<option value="1">No</option>
												</select>
											
										</td>
									</tr>
								
									<tr>
										<th>
											registradapor <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_registradapor"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											fecha <!-- (date) -->
										</th>
										<td>
											
												<?
													putCalendarInput("calendar_fecha");	
												?>
												<input 
													type = "hidden" 
													name= "date_fecha" 
													id= "date_fecha" 
													value = "vacio" 
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											justificacion <!-- (tinyint) -->
										</th>
										<td>
											
												<select 
													class="form-control" 
													name = "tinyint_justificacion" 
													id="tinyint_justificacion"
												>
									  				<option value="0">Sí</option>
									  				<option value="1">No</option>
												</select>
											
										</td>
									</tr>
								
									<tr>
										<th>
											observaciones <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_observaciones"
												/>
											
										</td>
									</tr>
								
						</table>
					</form>
					<center><a href="<?=$_SERVER['PHP_SELF']?>" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>asistencia</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    asistencia ha sido guardado <strong>exitosamente</strong>
					</div>
					<center><a href="<?=$_SERVER['PHP_SELF']?>" class="btn btn-default btn-sm">Volver</a></center>
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
