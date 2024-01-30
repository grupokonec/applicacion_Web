<?php
// Conexión a la base de datos
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "bdcl30";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el RUT del formulario
$rut = $_POST['rut'];
$fecha = $_POST['fecha'];
$mail = $_POST['mail'];

// Consulta SQL para insertar el RUT en la base de datos
$sql = "INSERT INTO lista_negra_email (rut,email,fecha) VALUES ('$rut','$mail','$fecha')";

if ($conn->query($sql) === TRUE) {
    echo 'Registro guardado exitosamente.'; 
} else {
    echo 'Error al guardar el registro.' . $conn->error;
}
header("refresh:0;url=../../view/dashboard.php");
// Cerrar la conexión a la base de datos
$conn->close();
?>
