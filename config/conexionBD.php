<?php

$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "konexnet";

try {
    $con = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    echo 'Error al conectarse con la base de datos: ' . $e->getMessage();
    exit;
}