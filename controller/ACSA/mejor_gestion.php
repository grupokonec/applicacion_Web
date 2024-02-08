<?php
include("../../config/conexionReporte.php");

$conn = new ConnectionOne("estadisticas");



// Verificar si se ha seleccionado un tipo de informe

$tipoCartera = $_POST['tipo_cartera'];

// Generar consulta según el tipo de informe seleccionado con su nombre especifico
switch ($tipoCartera) {
    case "CASTI00042":
        $nombre_archivo = "CASTI00042.csv";
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'CASTI00042'";
        $result = $conn->queryExe($sql);
        break;
    case "PTT01":
        $nombre_archivo = "PTT01.csv";
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'PTT01'";
        $result = $conn->queryExe($sql);
        break;
    case "DN_PR00009":
        $nombre_archivo = "DN_PR00009.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'DN_PR00009'";


        $result = $conn->queryExe($sql);

        break;
    case "ANT_A00009":
        $nombre_archivo = "ANT_A00009.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'ANT_A00009'";


        $result = $conn->queryExe($sql);

        break;
    case "NOVEN00028":
        $nombre_archivo = "NOVEN00028.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'NOVEN00028'";


        $result = $conn->queryExe($sql);

        break;
    case "DN_IN00008":
        $nombre_archivo = "DN_IN00008.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'DN_IN00008'";


        $result = $conn->queryExe($sql);

        break;
    case "MONTO00019":
        $nombre_archivo = "MONTO00019.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'MONTO00019'";


        $result = $conn->queryExe($sql);

        break;
    case "ORG_P00006":
        $nombre_archivo = "ORG_P00006.csv";
        // Llamar al primer procedimiento almacenado
        $sql = "SELECT * FROM estadisticas.mejor_gestion_20240205_20240229_11 WHERE cartera = 'ORG_P00006'";


        $result = $conn->queryExe($sql);

        break;
    default:
        echo "Tipo de informe no válido.";
        exit;
}
// Ejecutar la consulta
$result = $conn->queryExe($sql);



// Verificar si se encontraron resultados
if (count($result) > 0) {
    // Preparar los headers para la descarga del archivo CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');

    // Abrir el archivo en modo de escritura
    $output = fopen('php://output', 'w');

    // Escribir la cabecera del CSV (nombres de las columnas)
    // Asumiendo que todos los objetos en $result tienen las mismas propiedades
    if (!empty($result)) {
        $headers = array_keys(get_object_vars($result[0]));
        fputcsv($output, $headers);
    }

    // Escribir los datos en el CSV
    foreach ($result as $row) {
        // Convertir el objeto a un array para pasarlo a fputcsv
        fputcsv($output, get_object_vars($row));
    }
    fclose($output);
    exit;
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
$conn2->close();


?>