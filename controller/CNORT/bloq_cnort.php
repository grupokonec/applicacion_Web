<?php

// Obtener el RUT del formulario
$rut = $_POST['rut'];
$fecha = $_POST['fecha'];
$usu = $_POST['usu'];


// Conexión a la base de datos (reemplaza los valores con los de tu base de datos)
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";


$conn = new mysqli($servername, $username, $password);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}



// Consulta SQL para insertar el RUT en la base de datos
$sql1 = "INSERT INTO bdcl28.bloqueados (rut, fecha, sesion, fec_ing, glosa) VALUES ('$rut','$fecha', '$usu', '$fecha', 'interno')";

// Cerrar la conexión a la base de datos


// Consulta SQL para insertar el RUT en la base de datos
$sql2 = "INSERT INTO bdcl30.bloqueados (rut, fecha, sesion, fec_ing, glosa) VALUES ('$rut','$fecha', '$usu', '$fecha', 'interno')";


if ($conn->query($sql1) === TRUE &&  $conn->query($sql2) === TRUE ) {
    echo '<script language="javascript">alert("Registro guardados exitosamente.");</script>'; 
} else {
    echo '<script language="javascript">alert("Error al guardar el registro.");</script>' . $conn->error;
}
header("refresh:0;url=../../view/dashboard.php");
// Cerrar la conexión a la base de datos
$conn->close();
?>
