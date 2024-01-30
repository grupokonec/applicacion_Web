<?php
set_time_limit(600);
$fecproc_input = $_POST['fechaInicio'];
$fecproc_input2 = $_POST['fechaFin'];



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
$querySQL = "CALL proc_reporte_semanal_vsur()";
$stmt = $mysqli->prepare($querySQL);

// Verificar errores en la ejecución de la consulta
if ($stmt->error) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

// Ejecutar la consulta
$stmt->execute();

// Manejar resultados si es necesario
$stmt->store_result();

// Verificar si hay resultados antes de vincular
if ($stmt->num_rows > 0) {
    // Obtener los resultados
    $stmt->bind_result($reg); // Asignar el resultado a la variable $reg

    // Obtener los resultados
    $resultado = ""; // Aquí almacenarás los resultados del procedimiento almacenado

    while ($stmt->fetch()) {
        $resultado .= $reg . "\n"; // Modificar según sea necesario
    }
} else {
    $resultado = "No hay resultados disponibles";
}

// Cerrar la consulta
$stmt->close();

// Cerrar la conexión
$mysqli->close();

// Convertir las cadenas de fecha a objetos DateTime
$fecproc_datetime = new DateTime($fecproc_input);
$fecproc_datetime2 = new DateTime($fecproc_input2);

// Formatear las fechas como cadenas que incluyen año, mes y día
$fechaInicio = $fecproc_datetime->format('Ymd');
$fechaFin = $fecproc_datetime2->format('Ymd');

// Crear o sobrescribir el archivo de texto
$archivo = 'kon3ctados_' . $fechaInicio . '_' . $fechaFin . '_VSUR.txt';




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
