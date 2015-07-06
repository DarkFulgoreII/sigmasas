<?
	/***************************************************************************
	*                       MAIN CONFIGURATION
	***************************************************************************/
	
	
	define("COURSE_NAME","Sigma: Registro de asistencia");
	
	define("SITE","http://".$_SERVER['HTTP_HOST']."/sigmasas/");
	
	//define("MODULES_EDITOR_SHOW","/modules/editor/_samples/html/editor.php");
	//define("PATH_MODULE","/modules/editor/");
	
	
	/* OBJECTS */
	define("OBJ_PATH","../obj/");
	define("INC_PATH","../inc/");
	define("WEB_PATH","../web/");

	define("DEBUG_MODE", "ON");
	define("SUPPLANT_MODE", "OFF");
	define("SUPPLANT_USER", "am.molano10");
	define("SUPPLANT_ROLE", "MONITOR");
	require_once("inc/db_mysql.php");
	require_once('inc/configDB.php');
	require_once("inc/util.php");
	require_once("obj/sigmasas.php");
	require_once("obj/helper.php");

	//instanciar un container
	$contenedor = new sigmasas();
	$contenedor->idsigmasas = 1;
	$contenedor ->load();

	$helper = new Helper($contenedor);
?>