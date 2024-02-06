<?php
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "konexnet";

$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Tu consulta SQL
$querySQL = "CALL prueba_cron()";
$stmt = $mysqli->prepare($querySQL);

// Ejecutar la consulta
$stmt->execute();



// Procesar los resultadoserrar la consulta y la conexión
$stmt->close();
$mysqli->close();


exit;
?>
