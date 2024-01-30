<?php
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "pb01";

$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Tu consulta SQL
$querySQL = "SELECT * FROM Recaudado_historico_ACSA";
$stmt = $mysqli->prepare($querySQL);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$resultado = $stmt->get_result();

// Cadena para almacenar los datos
$datos = '';

// Procesar los resultados
while ($fila = $resultado->fetch_assoc()) {
    $datos .= implode("\t", $fila) . "\n"; // Cambia "\t" por "," si prefieres CSV
}

// Cerrar la consulta y la conexión
$stmt->close();
$mysqli->close();

// Nombre del archivo de salida
$archivo = 'acsa.txt';

// Guardar los datos en el archivo
file_put_contents($archivo, $datos);

// Cabeceras para forzar la descarga del archivo
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
header('Content-Length: ' . filesize($archivo));
readfile($archivo);

// Opcional: eliminar el archivo después de la descarga
 unlink($archivo);

exit;
?>
