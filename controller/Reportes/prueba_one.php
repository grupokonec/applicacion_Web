<?php

include('../../config/conexionReporte.php');
require_once 'ListaNegraController.php';
require_once 'RegistroContactoController.php';
require_once 'AllContactController.php';
require_once 'ExportCSVController.php';

$rc = new RegistroContactoController;
$ac = new AllContactController;
$export = new ExportCSVController;

if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {

    $fecha1 = $_GET['fechaInicio'];
    $fecha2 = $_GET['fechaFin'];

    // Formatea las fechas al formato de la base de datos ('Y-m-d')
    $fechaInicioFormateada = date('Y-m-d', strtotime($fecha1));
    $fechaFinFormateada = date('Y-m-d', strtotime($fecha2));

    $resultados_ac = $ac->validar($fechaInicioFormateada, $fechaFinFormateada);
    $resultados_rc = $rc->validar($fechaInicioFormateada, $fechaFinFormateada);
    $all = array_merge($resultados_ac, $resultados_rc);

    // Descargamos el reporte.
    $export->exportCSV($all, $fechaFinFormateada);
    // Finaliza la ejecución del script aquí para evitar que se devuelva cualquier contenido adicional
    exit;

} else {
    echo "No se recibieron los parámetros";
}
