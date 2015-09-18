<?
	require_once("./config.php");
	session_start();
	$courseName = COURSE_NAME;
	$_SESSION["courseName"] = $courseName;
	
	print_recursive("REQUEST", $_REQUEST);
	print_recursive("SESSION", $_SESSION);
	print_variable("SITE", SITE);
?>
<?	
	if(isset($_REQUEST['serverurl']))
	{
		$_SESSION['serverurl'] = $_REQUEST['serverurl'];
	}
	else
	{
		$_SESSION['serverurl'] = "other";	
	}
	if((isset($_REQUEST["userName"]) && isset($_REQUEST["role"]))) //falta preguntar por el referer
	{
		if(SUPPLANT_MODE == "ON")
		{
			$_SESSION["userName"] = SUPPLANT_USER;
			$_SESSION["role"] = SUPPLANT_ROLE;
		}
		else
		{
			$_SESSION["userName"] = $_REQUEST["userName"];
			$_SESSION["role"] = $_REQUEST["role"];	
		}
		
	}
	validar_referer($_SESSION['serverurl']);
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title><?= $courseName ?></title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>
	<body>
		
	<div class="well" >
		<img src="./img/cabezote.png" class="img-responsive img-rounded" alt="Sigma" width="100%" height="118">
	</div>	
<?	
	if(isset($_SESSION["userName"]) )
	{
		print_variable("site", SITE);
		if(isset ($_REQUEST["accion"]) && $_REQUEST["accion"]=="registrarAsistencia")
		{
			header('Location: '.SITE.'web/registrarAsistencia.php');
		}
		else if(isset ($_REQUEST["accion"]) && $_REQUEST["accion"]=="registrarEntrega")
		{
			header('Location: '.SITE.'web/registrarEntrega.php');
		}
		else if(isset ($_REQUEST["accion"]) && $_REQUEST["accion"]=="reporteAsistenciaGrupo")
		{
			header('Location: '.SITE.'web/reporteAsistenciaGrupo.php');
		}
		else if(isset ($_REQUEST["accion"]) && $_REQUEST["accion"]=="reporteAsistenciaCursos")
		{
			header('Location: '.SITE.'web/reporteAsistenciaCursos.php');
		}
?>
		<?
			include ("./inc/menu.php");
		?>
		<div class="well" >
			<div class="articles">
				<div class="row">
					<div class="col-xs-12 col-sm-5 col-md-5">
						<img class="img-responsive img-border" title="SigmaSAS" src="img/home.jpg" alt="SigmaSAS" />
					</div>
					<div class="col-xs-12 col-sm-7 col-md-7">			
						<div class="row">
							<div class="col-xs-12 col-sm-12">
								<h2>SigmaSAS</h2>
								<p>El sistema de registro de asistencia y seguimiento <strong>SigmaSAS</strong> fué desarrollado con el proposito de llevar un registro de seguimiento centralizado de los estudiantes del <strong>Programa Sigma</strong>. Entre otros, el sistema permite:</p>
								<ul class="list-group">
  									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Realizar registro en línea de la <strong>asistencia</strong> de los estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Registrar <strong>justificaciones</strong> y observaciones de <strong>seguimiento</strong> sobre la asistencia.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Generar <strong>listados de clase para imprimir</strong> copias físicas.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Registrar la realización de <strong>actividades</strong> por parte de los estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Registrar las <strong>calificaciones</strong> de actividades realizadas por los estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Registrar eventos de <strong>acompañamiento</strong> y citaciones a estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Registrar resultados de <strong>pruebas</strong> realizadas a estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Consultar reportes consolidados de <strong>asistencia</strong>.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Consultar reportes consolidados de <strong>entregas</strong>.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Calcular <strong>notas</strong> definitivas de estudiantes.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Consultar reportes consolidados de registros de <strong>acompañamiento</strong>.</li>
									<li class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Consultar reportes consolidados de registros de <strong>actividad en aulas virtuales</strong>.</li>

								</ul>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
		<?
		}
		else
		{
			include("web/denegado.php");
			//header('Location: '.SITE.'web/denegado.php');
		}
		?>
		<?include ("./inc/footer.php");?>
	</body>

</html>