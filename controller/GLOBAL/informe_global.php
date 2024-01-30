<?php
include("../../config/conexionReporte.php");

$fecha1 = "";
$fecha2 = "";

// Soportar tanto POST como GET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha1 = $_POST["fecha1"];
    $fecha2 = $_POST["fecha2"];
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $fecha1 = $_GET["fecha1"];
    $fecha2 = $_GET["fecha2"];
}

set_time_limit(600);

$conn = new ConnectionOne("bdcl1");

$query = "CALL proc_reporte_diario_1_copy(?,?)";

$stmt = $conn->queryExe($query, [$fecha1, $fecha2]);

// Comprobamos si la consulta fue exitosa
if ($stmt !== false) {
    // Convertir cada objeto stdClass a un array asociativo
    $data = array_map(function ($obj) {
        return (array) $obj;
    }, $stmt);

    $fechaInicioFormateada = date('Ymd', strtotime($fecha1));

    // Definir el nombre del archivo CSV
    $filename = "Informe_" . $fechaInicioFormateada . ".csv";

    // Enviar cabeceras para descargar el archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Abrir el flujo de salida
    $output = fopen("php://output", "w");

    // Escribir los encabezados de columna si existen
    if (!empty($data)) {
        fputcsv($output, array_keys($data[0]));
    }

    // Escribir los datos en el archivo CSV
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    // Cerrar el flujo de salida
    fclose($output);
    exit;
}

?>