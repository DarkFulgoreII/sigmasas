<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a href="<?=SITE?>index.php">Inicio</a></li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Asistencia <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/registrarAsistencia.php" >Registro de asistencia</a></li>
        <li><a href="<?=SITE?>web/reporteAsistenciaGrupo.php" >Ver registros de asistencia</a></li>                   
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Entregas <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/registrarEntrega.php" >Registro de actividades</a></li>                        
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Acompañamiento <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/registrarAcompanamiento.php" >Registro de acompañamiento a estudiantes</a></li>  
        <li><a href="<?=SITE?>web/registrarAcompanamientoMasivo.php" >Registro de acompañamiento (varios a la vez)</a></li>                      
        <li><a href="<?=SITE?>web/verAcompanamiento.php" >Ver o modificar registros de acompañamiento</a></li>
      </ul>
    </li>
    <?if(isset($_SESSION["userName"] ) && $_SESSION["userName"] != "carlos_tejada"):?>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pruebas <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?=SITE?>web/registrarPrueba.php" >Registro de pruebas a estudiantes</a></li>
        </ul>
      </li>
    <?endif;?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes <span class="caret"></span></a>
      <ul class="dropdown-menu"> 
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/asistencia/reporteTotalAsistenciayEntregas.rptdesign" >Reporte total de asistencia y entregas por grupo</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/asistencia/reporteTotalAsistenciayEntregasCoordinador.rptdesign" >Reporte total de asistencia y entregas por grupo (Coordinador)</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/asistencia/reporteTotalAsistenciayEntregasProfesor.rptdesign" >Reporte total de asistencia y entregas por grupo y curso (Profesor)</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/acompanamiento/reporteAcompanamientoCoordinador.rptdesign" >Reporte de acompañamiento (Coordinador)</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/acompanamiento/reporteAcompanamientoProfesor.rptdesign" >Reporte de acompañamiento (Profesor)</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/acompanamiento/reporteAcompanamientoGestor.rptdesign" >Reporte de acompañamiento (Gestor)</a></li>
        <?if(isset($_SESSION["userName"] ) && $_SESSION["userName"] != "carlos_tejada"):?>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/actividad/actividadPorEstudiante.rptdesign" >Reporte de actividad por grupo y curso</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/actividad/actividadPorGrupo.rptdesign" >Reporte de actividad por curso</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/actividad/actividadGeneral.rptdesign" >Reporte general de actividad por tipo de evento</a></li>
        <?endif;?>
      </ul>
    </li>
    <?if(isset($_SESSION["role"] ) && $_SESSION["role"] == "ADMIN"):?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Indicadores de evaluación <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/reporteIndicadoresEvaluacionEspanol.rptdesign" >Reporte de indicadores de Español</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/reporteIndicadoresEvaluacionPrecalculo.rptdesign" >Reporte de indicadores de Precálculo</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/reporteIndicadoresEvaluacionVidaUniversitaria.rptdesign" >Reporte de indicadores de Vida Universitaria</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/indicadoresPorNivelES.rptdesign" >Reporte de indicadores por nivel Español</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/indicadoresPorNivelPC.rptdesign" >Reporte de indicadores por nivel Precálculo</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/evaluacion/indicadoresPorNivelVU.rptdesign" >Reporte de indicadores por nivel Vida Universitaria</a></li>
          <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/entregas/reporteEntregasPorIntervalos.rptdesign" >Reporte de calificaciones por intervalos</a></li>
      </ul>
    </li>
    <?endif;?>
    <?if(isset($_SESSION["role"] ) && $_SESSION["role"] == "ADMIN"):?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Opciones administrativas <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?=SITE?>web/moverReportesAsistencia.php" >Mover registros de asistencia</a></li>  
        <li><a href="<?=SITE?>web/limpiarReportesAsistencia.php" >Limpiar registros de asistencia</a></li>
        <li><a target="_blank" href="http://saravena.uniandes.edu.co:8080/sigmasasreports/frameset?__report=sigmasas_reports/mesaAyuda/casosMesaAyuda.rptdesign" >Reporte de casos de la mesa de ayuda</a></li>
        <li><a target="_blank" href="http://sigma.uniandes.edu.co/awstats/awstats.pl" >Estadísticas del portal Sigma</a></li>
      </ul>
    </li>
    <?endif;?>

</ul>
</div>
