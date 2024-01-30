<?php

//procedimiento valido 
// Conexión a la base de datos
$fecproc_input = $_POST['fechaInicio'];

$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "bdcl30";

$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Tu consulta SQL
$querySQL = "CALL proc_reporte_diario_vsur(?)";
$stmt = $mysqli->prepare($querySQL);

// Verificar errores en la preparación de la consulta
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $mysqli->error);
}

$stmt->bind_param('s', $fecproc_input);
$stmt->execute();

// Verificar errores en la ejecución de la consulta
if ($stmt->error) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

// Manejar resultados si es necesario
$stmt->store_result();

// Obtener los resultados
$stmt->bind_result($reg); // Asignar el resultado a la variable $reg

// Obtener los resultados
$resultado = ""; // Aquí almacenarás los resultados del procedimiento almacenado

while ($stmt->fetch()) {
    $resultado .= $reg . "\n"; // Modificar según sea necesario
}

// Cerrar la consulta
$stmt->close();

// Cerrar la conexión
$mysqli->close();

// Convertir la cadena de fecha a un objeto DateTime
$fecproc_datetime = new DateTime($fecproc_input);

// Formatear la fecha como una cadena que incluye año, mes y día
$formatoFecha = $fecproc_datetime->format('Ymd');

// Crear o sobrescribir el archivo de texto
$archivo = 'AVS_COB_44_' . $formatoFecha . '.txt';

file_put_contents($archivo, $resultado);

// Descargar el archivo
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
header('Content-Length: ' . filesize($archivo));
readfile($archivo);

// Eliminar el archivo después de la descarga (opcional)
unlink($archivo);
exit;
?>
