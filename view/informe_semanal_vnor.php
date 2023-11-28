<?php
// Conexión a la base de datos
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$dbname = "bdcl31";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta a la vista en la base de datos
$sql = "SELECT * FROM vw_reporte_semanal";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar el archivo de descarga (CSV en este ejemplo)
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="informe_semanal_vnor.csv"');

  // Configurar el delimitador para el archivo CSV
  $output = fopen('php://output', 'w');

  // Obtener los nombres de las columnas y escribir la cabecera en el archivo CSV
  $columns = [];
  while ($row = $result->fetch_assoc()) {
      $columns = array_keys($row);
      break;
  }
  fputcsv($output, $columns, ';'); // Cabecera

  // Escribir los datos en el archivo con el delimitador especificado
  mysqli_data_seek($result, 0); // Reiniciar el puntero del resultado
  while ($row = $result->fetch_assoc()) {
      fputcsv($output, $row, ';');
  }
  fclose($output);
} else {
  echo "No se encontraron resultados";
}

$conn->close();
?>