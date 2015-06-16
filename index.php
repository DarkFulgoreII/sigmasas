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
		
	<div class="well" ><img src="./img/cabezote.png" class="img-responsive" alt="Sigma" width="1055" height="118"></div>	
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
			
			<p><h4><strong>Sigma SAS</strong> - Sistema de registro de y asistencia y seguimiento del programa Sigma</h4></p>
			<table class="table table-bordered" align="center">
				<tr>
					<th align="center"><center>Menú Principal</center></th>
				</tr>
				<tr>
					<td align="center"><a href="web/registrarAsistencia.php" class="btn btn-default btn-sm">Registrar asistencia a sesiones</a></td>
				</tr>
				<tr>
					<td align="center"><a href="web/registrarEntrega.php" class="btn btn-default btn-sm">Registrar entregas y actividades</a></td>
				</tr>
				<tr>
					<td align="center"><a href="web/reporteAsistenciaGrupo.php" class="btn btn-default btn-sm">Reporte de asistencia por grupos</a></td>
				</tr>
				<tr>
					<td align="center"><a href="web/reporteAsistenciaCursos.php" class="btn btn-default btn-sm">Reporte de asistencia por cursos</a></td>
				</tr>
			</table>
		</div>
		<?
		}
		else
		{
			include("web/denegado.php");
			//header('Location: '.SITE.'web/denegado.php');
		}
		?>
		<div class="panel-footer">
			<?if (isset($_SESSION["userName"])): ?>
				Usuario : <?=$_SESSION["userName"]?>  
			<? endif; ?>
		</div>
	</body>

</html>