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
		<title>Crear semana</title>
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
					
					<h4>Crear semana</h4>
					<form id = "frm_agregar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						

						<table class="table table-bordered" >
							
								<!--simple attributes-->
								
									<tr>
										<th>
											fechainicial <!-- (date) -->
										</th>
										<td>
											
												<?
													putCalendarInput("calendar_fechainicial");	
												?>
												<input 
													type = "hidden" 
													name= "date_fechainicial" 
													id= "date_fechainicial" 
													value = "vacio" 
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											fechafinal <!-- (date) -->
										</th>
										<td>
											
												<?
													putCalendarInput("calendar_fechafinal");	
												?>
												<input 
													type = "hidden" 
													name= "date_fechafinal" 
													id= "date_fechafinal" 
													value = "vacio" 
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											cohorte <!-- (int) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "int_cohorte"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											numerosemana <!-- (int) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "int_numerosemana"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											descripcion <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_descripcion"
												/>
											
										</td>
									</tr>
								
						</table>
					</form>
					<center><a href="<?=$_SERVER['PHP_SELF']?>" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>semana</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    semana ha sido guardado <strong>exitosamente</strong>
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
