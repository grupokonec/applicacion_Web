<?php
include('../../config/conexionReporte.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ddd = $_POST['fechamonth'];
    $option = $_POST['buttonsValue'];

    list($year, $month) = explode('-', $ddd);

    // Define un array para la respuesta JSON
    $response = ["success" => false, "data" => [], "type" => ""];

    if ($option == 'email') {
        // Instancia el objeto de conexión
        $conexion = new ConnectionOne("email");

        // Llama al procedimiento almacenado con dos parámetros
        $query = "CALL Rhh_Email(?,?)";
        $stmt = $conexion->queryExe($query, [$month, $year]);

        // Verifica si la consulta fue un SELECT antes de obtener los resultados
        if ($stmt !== false) {
            // Obtiene los resultados como un array
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Configura la respuesta JSON
            $response["data"] = $data;
            $response["type"] = "email";
            $response["success"] = true;
        }
    } else {
        // Instancia el objeto de conexión
        $conexion = new ConnectionOne("sms");

        // Llama al procedimiento almacenado con dos parámetros
        $query = "CALL Rhh_Sm_salco(?, ?)";
        $stmt = $conexion->queryExe($query, [$month, $year]);

        // Verifica si la consulta fue un SELECT antes de obtener los resultados
        if ($stmt !== false) {
            // Obtiene los resultados como un array
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Configura la respuesta JSON
            $response["data"] = $data;
            $response["type"] = "sms";
            $response["success"] = true;
        }
    }

    // Devuelve la respuesta JSON al cliente
    echo json_encode($response);
}
?>
