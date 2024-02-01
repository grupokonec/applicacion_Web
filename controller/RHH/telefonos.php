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
    $stmt = $conexion->queryExe($query, [$month, $year]);

    // Verifica si la consulta fue un SELECT antes de obtener los resultados
    if ($stmt instanceof PDOStatement) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configura la respuesta JSON
        $response["data"] = $data;
        $response["success"] = true;
    }

    echo json_encode($response);
}

?>