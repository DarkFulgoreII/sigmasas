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
		<title>Crear estudiante</title>
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
					
					<h4>Crear estudiante</h4>
					<form id = "frm_agregar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						

						<table class="table table-bordered" >
							
								<!--simple attributes-->
								
									<tr>
										<th>
											nombres <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_nombres"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											apellido1 <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_apellido1"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											apellido2 <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_apellido2"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											genero <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_genero"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											estadocivil <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_estadocivil"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											fechanacimiento <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_fechanacimiento"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											nacionalidad <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_nacionalidad"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											tipodocumento <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_tipodocumento"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											numdocumento <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_numdocumento"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											etnia <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_etnia"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											email <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_email"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											telefonofijo <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_telefonofijo"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											telefonomovil <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_telefonomovil"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											ciudadresidencia <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_ciudadresidencia"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											direccionresidencia <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_direccionresidencia"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudienteapellido1 <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudienteapellido1"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudienteapellido2 <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudienteapellido2"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudientenombres <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudientenombres"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudienterelacion <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudienterelacion"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudientetelefonofijo <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudientetelefonofijo"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudientetelefonomovil <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudientetelefonomovil"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudienteciudadresidencia <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudienteciudadresidencia"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											acudientedireccionresidencia <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_acudientedireccionresidencia"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											institucion <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_institucion"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											egreso <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_egreso"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											saber11 <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_saber11"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											anhosaber <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_anhosaber"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											saber11matematica <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_saber11matematica"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											saber11espanol <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_saber11espanol"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											estudiaactualmente <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_estudiaactualmente"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											actualmenteestudiaotros <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_actualmenteestudiaotros"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											admisioncentroeducativo <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_admisioncentroeducativo"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											estatrabajando <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_estatrabajando"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											planescortoplazo <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_planescortoplazo"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											planescortoplazootros <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_planescortoplazootros"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											interesformacion <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_interesformacion"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											interesformacionotros <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_interesformacionotros"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											experienciavirtuales <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_experienciavirtuales"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											estrato <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_estrato"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											sisben <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_sisben"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											especiales <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_especiales"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											discapacidades <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_discapacidades"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											victima <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_victima"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											desmovilizado <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_desmovilizado"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											hijodesmovilizado <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_hijodesmovilizado"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											desplazado <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_desplazado"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											internet <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_internet"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											internetcalidad <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_internetcalidad"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											codigouniandes <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_codigouniandes"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											correouniandes <!-- (varchar) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "varchar_correouniandes"
												/>
											
										</td>
									</tr>
								
									<tr>
										<th>
											desactivado <!-- (tinyint) -->
										</th>
										<td>
											
												<select 
													class="form-control" 
													name = "tinyint_desactivado" 
													id="tinyint_desactivado"
												>
									  				<option value="0">Sí</option>
									  				<option value="1">No</option>
												</select>
											
										</td>
									</tr>
								
									<tr>
										<th>
											moodleid <!-- (int) -->
										</th>
										<td>
											
												<input 
													type="text" 
													value = "" 
													id = "int_moodleid"
												/>
											
										</td>
									</tr>
								
						</table>
					</form>
					<center><a href="<?=$_SERVER['PHP_SELF']?>" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "guardar") { ?>
				<div class="well">
					<h4>estudiante</h4>
					<div class="alert alert-success fade in">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    estudiante ha sido guardado <strong>exitosamente</strong>
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
