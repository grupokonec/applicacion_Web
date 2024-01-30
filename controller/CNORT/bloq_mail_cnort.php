<?php
// Obtener el RUT del formulario
$rut = $_POST['rut'];
$fecha = $_POST['fecha'];
$mail = $_POST['mail'];
// Conexión a la base de datos
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";


$conn = new mysqli($servername, $username, $password);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}



// Consulta SQL para insertar el RUT en la base de datos
$sql1 = "INSERT INTO bdcl28.lista_negra_email (rut,email,fecha) VALUES ('$rut','$mail','$fecha')";
// Consulta SQL para insertar el RUT en la base de datos
$sql2 = "INSERT INTO bdcl30.lista_negra_email (rut,email,fecha) VALUES ('$rut','$mail','$fecha')";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo '<script language="javascript">alert("Registro guardado exitosamente.");</script>'; 
} else {
    echo '<script language="javascript">alert("Error al guardar el registro.");</script>' . $conn->error;
}
header("refresh:0;url=../../view/dashboard.php");
// Cerrar la conexión a la base de datos
$conn->close();
?>

