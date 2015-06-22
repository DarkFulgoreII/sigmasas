<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="<?=SITE?>index.php">Inicio</a></li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Asistencia <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/registrarAsistencia.php" >Registro de asistencia</a></li>
        <li><a href="<?=SITE?>web/reporteAsistenciaGrupo.php" >Reporte de asistencia por grupo</a></li>                   
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Entregas <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/registrarEntrega.php" >Registro de actividades</a></li>                        
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes <span class="caret"></span></a>
      <ul class="dropdown-menu"> 
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/asistencia/tablaAsistenciaConsolidada.rptdesign" >Tabla consolidada de asistencia</a></li> 
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/asistencia/reporteTotalAsistenciayEntregas.rptdesign" >Reporte total de asistencia y entregas por grupo</a></li>                      
      </ul>
    </li>
    <?if(isset($_SESSION["role"] ) && $_SESSION["role"] == "ADMIN"):?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Opciones administrativas <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/moverReportesAsistencia.php" >Mover registros de asistencia</a></li>  
        <li><a href="<?=SITE?>web/limpiarReportesAsistencia.php" >Limpiar registros de asistencia</a></li>                      
      </ul>
    </li>
    <?endif;?>

</ul>
</div>
