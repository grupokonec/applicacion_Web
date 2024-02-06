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
        $data = $conexion->queryExe($query, [$month, $year]);

        // Verifica si la consulta fue exitosa antes de configurar la respuesta
        if ($data !== false) {
            // Configura la respuesta JSON
            $response["data"] = $data;
            $response["type"] = "email";
            $response["success"] = true;
        } else {
            // Manejo de error, en caso de que la consulta falle
            $response["error"] = "Error al ejecutar la consulta.";
        }
    } else {
        // Instancia el objeto de conexión
        $conexion = new ConnectionOne("sms");

        // Llama al procedimiento almacenado con dos parámetros
        $query = "CALL Rhh_Sm_salco(?, ?)";
        $data = $conexion->queryExe($query, [$month, $year]); // $data ya debería ser un array

        // Verifica si $data no es false para continuar
        if ($data !== false) {
            // $data ya es un array con los resultados, no necesitas llamar a fetchAll

            // Configura la respuesta JSON
            $response["data"] = $data;
            $response["type"] = "sms";
            $response["success"] = true;
        } else {
            // Manejo de error, en caso de que la consulta falle
            $response["success"] = false;
            $response["error"] = "Error al ejecutar la consulta.";
        }
    }



    // Devuelve la respuesta JSON al cliente
    echo json_encode($response);
}
?>