<?php
include('../../config/conexionReporte.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ddd = $_POST['fechamonth1'];

    list($year, $month) = explode('-', $ddd);

    // Define un array para la respuesta JSON
    $response = ["success" => false, "data" => [], "type" => ""];

    $conexion = new ConnectionOne("report00");

    // Llama al procedimiento almacenado con dos parámetros
    $query = "CALL proc_Rhh_get_time_call(?,?)";
    $data = $conexion->queryExe($query, [$month, $year]);

    // Verifica si la consulta fue exitosa antes de configurar la respuesta
    if ($data !== false) {
        // Configura la respuesta JSON
        $response["data"] = $data;
        $response["type"] = "time_call"; // Asumo el tipo basado en el nombre del procedimiento
        $response["success"] = true;
    } else {
        // Opcional: Agregar manejo de error en caso de que la consulta falle
        $response["error"] = "Error al ejecutar la consulta.";
    }

    // Envía la respuesta JSON
    echo json_encode($response);
}

?>