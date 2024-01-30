<?php
$servername = "52.54.246.25";
$username = "cron";
$password = "1234";
$database = "test";

try {
    set_time_limit(600);
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha1 = $_POST["fechaInicio"];
    $fecha2 = $_POST["fechaFin"];

    $response = ["success" => false, "data" => [], "type" => ""];

    try {
        $query = "SELECT * FROM audios_final WHERE date(incio_call) BETWEEN :fecha1 AND :fecha2";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fecha1', $fecha1);
        $stmt->bindParam(':fecha2', $fecha2);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["data"] = $data;
        $response["success"] = true;
    } catch (PDOException $e) {
        $response["type"] = "Error de consulta: " . $e->getMessage();
    }

    echo json_encode($response);
}
?>
