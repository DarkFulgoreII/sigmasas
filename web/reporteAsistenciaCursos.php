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
		
		$grupo = new grupo();
		$grupo->set_idgrupo($_REQUEST['combo_grupo']);
		$grupo->load();

		$estudiantes = array();
		if($grupo != false)
		{
			$estudiantes = $grupo ->get_estudiante_collection();
			$estudiantes = $helper ->ordenarEstudiantes($estudiantes);
		}
		
		//se traen las asistencias de cada estudiante de la seccion en este bloque y fecha
		$porcentajes =array();
		$cantidades = array();
		$totales = array();

		foreach ($estudiantes as  $estudiante) 
		{
			//traer las secciones a las que pertenece el estudiante de cada curso

			foreach($cursos as $curso)
			{
				//traer la sección del curso al que está inscrito el estudiante
				$seccion = $helper->darSeccion_por_grupoCurso( $curso, $grupo);
				if($seccion != false)
				{
					$asistenciaestudiantecurso =  $helper->darAsistencias_por_estudianteSeccion($estudiante, $seccion);
					
					$sesionesTotales =0;
					$sesionesAsiste = 0;
					$sesionesJustificadas = 0;
					foreach ($asistenciaestudiantecurso as $fecha) 
					{
						foreach ($fecha as $asistencia)
						{
							$sesionesTotales ++;
							if($asistencia->get_asiste()=="1") $sesionesAsiste++;
							if($asistencia->get_justificacion()=="1")$sesionesJustificadas++;
						}
					}
					$porcentajeCurso=0;
					if($sesionesTotales>0)	$porcentajeCurso = (($sesionesAsiste+$sesionesJustificadas) / $sesionesTotales) *100;
					$porcentajes[$estudiante->get_idestudiante()][$curso->get_idcurso()] =$porcentajeCurso;
					$cantidades[$estudiante->get_idestudiante()][$curso->get_idcurso()] = $sesionesAsiste+$sesionesJustificadas;
					$totales [$estudiante->get_idestudiante()][$curso->get_idcurso()] = $sesionesTotales;
				}
			}
		}
		
		print_recursive("porcentajes", $porcentajes);
		print_recursive("cantidades", $cantidades);
		print_recursive("totales", $totales);
	}
?>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Reporte de asistencia por curso</title>
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
					<h4>Reporte de asistencia por cursos</h4>
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "generar" />
						<table class="table table-bordered" >
							<tr>
								<th>
									Seleccione el grupo: 
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
					<center><a href="./reporteAsistenciaCursos.php" class="btn btn-default btn-sm">Volver</a></center>
				</div>
			<? 
				}else if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "generar"){ 
			?>
				<div class="well">
					<h4>Reporte de asistencia por cursos</h4>
					<table class="table table-bordered">
						<tr>
							<th>
								 <span class="glyphicon glyphicon-user"></span> Grupo
							</th>
						</tr>
						<tr>
							<td>
								<small><? eecho ($grupo->get_nombre()); ?></small>
							</td>
						</tr>
					</table>
				</div>
				<div class="well">
					<form id = "frm_registrar" method = "POST" accept-charset="UTF-8" action="<?=$_SERVER['PHP_SELF']?>">
						<input type = "hidden" name= "action" id= "action" value = "guardar" />
						<input type = "hidden" name= "hidden_grupo" id= "hidden_grupo" value = "<?=$_REQUEST['combo_grupo']?>" />
						<table class="table table-hover">	
							<tr>
								<th colspan = "6"><h4>Datos básicos</h4></th>
								<th colspan = <? eecho ( count($cursos)*2 ); ?> ><h4>Cursos</h4></th>
							</tr>
							<tr>
								<th><h4>Código</h4></th>
								<th><h4>Apellidos</h4></th>
								<th><h4>Nombres</h4></th>
								<th><h4>Correo electrónico</h4></th>
								<th><h4>Teléfono fijo</h4></th>
								<th><h4>Teléfono móvil</h4></th>
								<?
									foreach ($cursos as $curso):
								?>
										<th colspan = "2">
											<small><? eecho ($curso->get_nombre()); ?></small>
										</th>
								<?
									endforeach;
								?>
							</tr>
							<? 
								foreach($estudiantes as $estudiante): 
									
							?>
								<tr>
									<td><font size="1"><?= $estudiante->get_codigouniandes() ?></font></td>
									<td><font size="1"><? eecho($estudiante->get_apellido1());  ?> <? eecho($estudiante->get_apellido2()); ?></font></td>
									<td><font size="1"><?= $estudiante->get_nombres() ?></font></td>

									<td><font size="1"><?= $estudiante->get_correouniandes() ?></font></td>
									<td><font size="1"><?= $estudiante->get_telefonofijo() ?></font></td>
									<td><font size="1"><?= $estudiante->get_telefonomovil() ?></font></td>
									
									<?
										foreach($cursos as $curso):
											if(isset($porcentajes[$estudiante->get_idestudiante()][$curso->get_idcurso()]))
											{
												$porcentajeCurso = $porcentajes[$estudiante->get_idestudiante()][$curso->get_idcurso()];			
												$porcentajeCurso = number_format($porcentajeCurso, 2, '.', ',');
												$cantidadCurso  = $cantidades[$estudiante->get_idestudiante()][$curso->get_idcurso()];
												$totalesCurso = $totales[$estudiante->get_idestudiante()][$curso->get_idcurso()];
											}
											$claseporcentaje = "class='danger'";
											if($porcentajeCurso >= 85) $claseporcentaje = "class='success'";
									?>
											<td
												<?=$claseporcentaje?>
											>
												<font size="1"><?= $cantidadCurso  ?> de  <?= $totalesCurso  ?></font>
											</td>
											<td
												<?=$claseporcentaje?>
											>
												<font size="1">(<?= $porcentajeCurso  ?> %)</font>
											</td>
										<? endforeach;?>
								</tr>
							<? 
								endforeach; // foreach de estudiantes 
							?>
						</table>
						<center>
							<a href="#" class="btn btn-default btn-sm" id = "submit_imprimir" onClick="window.print();">
      							<span class="glyphicon glyphicon-print"></span> Imprimir 
    						</a>
							<a href="./reporteAsistenciaCursos.php" class="btn btn-default btn-sm">Volver</a>
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