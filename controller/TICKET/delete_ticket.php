<?php
include("../../config/conexionReporte.php");

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $id = $_REQUEST["id"];

    try {
        $conexion = new ConnectionOne("konexnet");

        // Usar marcador de posición en la consulta
        $query = "DELETE FROM ticket WHERE id = ?";
        $params = [$id];

        // Ejecutar la consulta
        $conexion->queryExe($query, $params);

        $response = ["success" => "success"];
    } catch (Error $e) {
        $response = ["error" => $e->getMessage()];
    }

    echo json_encode($response);
}


?>