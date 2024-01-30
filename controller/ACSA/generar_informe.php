<?php

// Parámetros de entrada del formulario
$fecproc_input = $_POST['fechaInicio'];
$fecproc_input2 = $_POST['fechaFin'];
$tipo_cobranza = $_POST['tipo_cobranza'];

// Detalles de la conexión a la base de datos
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "test";

// Crear la conexión a la base de datos
$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Llamar al procedimiento almacenado con dos valores
$querySQL = "CALL proc_crea_reportes_acsa(?, ?)";
$stmt = $mysqli->prepare($querySQL);

// Verificar errores en la preparación de la consulta
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $mysqli->error);
}

$stmt->bind_param('ss', $fecproc_input, $fecproc_input2);
$stmt->execute();

// Verificar errores en la ejecución de la consulta
if ($stmt->error) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

// Cerrar la consulta
$stmt->close();

// Realizar la consulta a la tabla después de ejecutar el procedimiento almacenado
$sql = "SELECT ic,cc,rut,nombre,Email,Marca_Email,Telefono,Marca_Telefono,Area_Responsable,Origen_accion,fecha,Importe,Tipo_accion,Resultado_de_Accion,Observacion FROM tbl_reportes_acsa WHERE tipo_cobranza = '$tipo_cobranza'";
$result = $mysqli->query($sql);

// Manejar resultados si es necesario
if ($result) {
    $nombre_archivo = "informe_diario.csv";

    if ($result->num_rows > 0) {
        // Generar el archivo de descarga (CSV en este ejemplo)
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');

        // Configurar el delimitador para el archivo CSV
        $output = fopen('php://output', 'w');

        // Obtener los nombres de las columnas y escribir la cabecera en el archivo CSV
        $columns = $result->fetch_fields();
        $column_names = array_map(function ($column) {
            return $column->name;
        }, $columns);
        fputcsv($output, $column_names, ';'); // Cabecera

        // Escribir los datos en el archivo con el delimitador especificado
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row, ';');
        }
        fclose($output);
    } else {
        echo "No se encontraron resultados";
    }
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

// Cerrar la conexión
$mysqli->close();

?>
