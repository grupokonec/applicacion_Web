<?php
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "konexnet";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar la conexión después de haber creado la instancia
    if (!$conn) {
        die("Conexión fallida");
    }
} catch (PDOException $e) {
    echo 'Error al conectarse con la base de datos: ' . $e->getMessage();
    exit;
}



