<?
	session_start();
	require_once("../config.php");
	// cargar los posibles cursos
	$cursos = $contenedor->get_curso_collection();
	// cargar los posibles grupos
	$grupos = $contenedor->get_grupo_collection();
	//cargar bloques
	$bloques = $helper->ordenarBloques($contenedor->get_bloque_collection());
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
				}
			}
			
		}
		print_recursive("fechas", $fechas);
		print_recursive("bloques", $bloques);
		print_recursive("sesiones_validas", $sesionesvalidas);
		//print_recursive ("asistencias", $asistencias);
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Reporte de asistencia por grupo</title>
		<?
			include_javascript();
		?>
	</head>
	<body>
		<div class="well" ><img src="../img/cabezote.png" class="img-responsive" alt="Sigma" width="1055" height="118"></div>
		
		<?include ("../inc/menu.php");?>

		<? if(isset($_SESSION["userName"])): ?>
			<? if(!isset($_REQUEST["action"])){ ?>
				<div class="well" >
					
					<h4>Reporte de asistencia por grupo</h4>
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
										<input class="btn btn-default btn-sm" id = "submit_generar" type = "submit" value="Generar reporte" onClick="document.getElementById('action').value='generar'; "/>
									</center>
								</td>
							</tr>
						</table>
					</form>
					<center><a href="./reporteAsistenciaGrupo.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					
					<h4>Reporte de asistencia por grupo</h4>
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
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_curso" id= "hidden_curso" value = "<?=$_REQUEST['combo_curso']?>" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<table class="table table-hover">	
							<tr>
								<th colspan = "6"><h4>Datos básicos</h4></th>
								<th colspan = <? eecho (count($fechas)* count($bloques)); ?> ><h4>Sesiones</h4></th>
							</tr>
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Apellidos</h4></th>
								<th><h4>Nombres</h4></th>
								<th><h4>Correo electrónico</h4></th>
								<th><h4>Teléfono fijo</h4></th>
								<th><h4>Teléfono móvil</h4></th>
								<?
									foreach ($fechas as $fecha):
										foreach($bloques as $bloque):
											$bloqueobjeto = new bloque($bloque);
											$bloqueobjeto->load();
								?>
											<?
												if(isset($sesionesvalidas[$fecha."__".$bloque])):
											?>
											<th>
												<small>Sesión: <? eecho ($fecha) ?> <br/> <? eecho ($bloqueobjeto->get_descripcion()); ?></small>
												<br>
												<? if (isset($_SESSION['role'])  && $_SESSION['role'] == "ADMIN"): ?>
												<a class="btn btn-primary btn-xs" href = "./moverReportesAsistencia.php?action=modificar&hidden_curso=<?=$_REQUEST['combo_curso']?>&hidden_grupo=<?=$_REQUEST['combo_grupo']?>&hidden_paquete=<?=$fecha."__".$bloque?>">Mover</a>
												<a class="btn btn-danger btn-xs" href = "./limpiarReportesAsistencia.php?action=limpiar&hidden_curso=<?=$_REQUEST['combo_curso']?>&hidden_grupo=<?=$_REQUEST['combo_grupo']?>&hidden_paquete=<?=$fecha."__".$bloque?>">Borrar</a>
												<? endif; ?>
											</th>
											<?
												endif;
											?>
								<?
										endforeach;
									endforeach;
								?>
								<th><h4>Total</h4></th>
								<th><h4>Porcentaje</h4></th>
							</tr>
							<? 
								foreach($estudiantes as $estudiante): 
									$totalasistencias = 0;
									$totalregistros = 0;
							?>
								<tr>
									<td><small><?= $estudiante->get_codigouniandes() ?></small></td>
									<td><small><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></small></td>
									<td><small><?= $estudiante->get_nombres() ?></small></td>

									<td><small><?= $estudiante->get_correouniandes() ?></small></td>
									<td><small><?= $estudiante->get_telefonofijo() ?></small></td>
									<td><small><?= $estudiante->get_telefonomovil() ?></small></td>
									<?
										if(isset ($asistencias[$estudiante->get_idestudiante()]))
										{
											
											$asistencias_estudiante = $asistencias[$estudiante->get_idestudiante()];

											foreach ($fechas as $fecha)
											{
												foreach($bloques as $bloque)
												{
													if(isset($sesionesvalidas[$fecha."__".$bloque]))
													{
														$totalregistros++;

														$bloqueobjeto = new bloque($bloque);
														$bloqueobjeto->load();

														$icono_asiste = "glyphicon glyphicon-ban-circle";
														$claseasiste = "class='danger'";
														//print_variable("f", $fecha);
														//print_variable("b", $bloque);

														if(isset($asistencias_estudiante[$fecha][$bloque]))
														{
															$asistencia_fecha_bloque = $asistencias_estudiante[$fecha][$bloque];

															if($asistencia_fecha_bloque->get_asiste()=="1")
															{
																$claseasiste = "class='success'";
																$icono_asiste = "glyphicon glyphicon-ok-circle";
																$totalasistencias++;		
															}
															else
															{
																if($asistencia_fecha_bloque->get_justificacion()=="1")
																{
																	$claseasiste = "class='warning'";
																	$icono_asiste = "glyphicon glyphicon-info-sign";
																	$totalasistencias++;
																}
															}
															?>
																<td <?= $claseasiste ?>>
																	
																	<span 
																		class="<?= $icono_asiste?>"
																		title="Sesión: <? eecho($fecha);  ?> - Bloque: <? eecho($bloque);  ?>"
																		>
																	</span>
																	<small><?if($asistencia_fecha_bloque->get_justificacion()=="1") eecho ("(Justificada)");?></small>
																</td>
															<?
														}else{
															?>
																<td <?= $claseasiste ?>>
																	<span 
																		class="<?= $icono_asiste ?>"
																		title="No registrada"
																	>
																		<small>(Sin registro)</small>
																	</span>
																</td>
															<?
														}

													}
													//----------------------------------------------------------------
													
												}
											}
										}
	
									?>
									<?
										$porcentaje = ($totalasistencias / $totalregistros )* 100;
										

										$claseporcentaje = "class='danger'";
										$clasenumero = "class='danger'";
										if($totalasistencias > 0) $clasenumero = "class='success'";
										if($porcentaje >= 85) $claseporcentaje = "class='success'";
										$porcentaje = number_format($porcentaje, 2, '.', ',');
									?>
									<td <?=$clasenumero?> ><small><? eecho ($totalasistencias); ?> de <? eecho ($totalregistros); ?></small></td>
									<td <?=$claseporcentaje?> ><small><? eecho ($porcentaje) ; ?>%</small></td>
									
								</tr>
							<? endforeach; // foreach de estudiantes ?>
						</table>
						<center>
							<a href="#" class="btn btn-default btn-sm" id = "submit_imprimir" onClick="window.print();">
      							<span class="glyphicon glyphicon-print"></span> Imprimir 
    						</a>
							<a href="./reporteAsistenciaGrupo.php" class="btn btn-default btn-sm">Volver</a>
						</center>
					</form>
					
				</div>
			<? }else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "imprimir") { ?>
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
						<table class="table table-bordered">	
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Apellidos</h4></th>
								<th><h4>Nombres</h4></th>
								<th><h4>Firma</h4></th>
								
							</tr>
							<? foreach($estudiantes as $estudiante):?>
								<tr>
									<td><small><?= $estudiante->get_codigouniandes() ?></small></td>
									<td><small><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></small></td>
									<td><small><?= $estudiante->get_nombres() ?></small></td>
									<td width="30%"></td>
								</tr>
							<? endforeach; ?>
							<tr border="1">
								<td colspan="2">
									Firma del responsable:
								</td>
								<td colspan="2" >
									
								</td>
							</tr>
							
						</table>
						<center>
							
							<a class="btn btn-default btn-sm" href="./registrarAsistencia.php">Volver</a>
						</center>
					</form>
				</div>	
			<? }?> 
		<?
			else:
				include(WEB_PATH."denegado.php");
			endif;
		?>
	<div class="panel-footer">
			<?if (isset($_SESSION["userName"])): ?>
				Usuario : <?=$_SESSION["userName"]?>  
			<? endif; ?>
		</div>
	</body>
</html>