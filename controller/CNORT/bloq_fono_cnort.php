<?php
// Obtener el RUT del formulario
$rut = $_POST['rut'];
$fecha = $_POST['fecha'];
$fono = $_POST['fono'];


// Conexión a la base de datos
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";

$conn = new mysqli($servername, $username, $password);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Conexión a la base de datos ds7
$servername2 = "52.6.25.63";
$username2 = "cron";
$password2 = "1234";
$database2 = "asterisk";

$conn2 = new mysqli($servername2, $username2, $password2, $database2);

// Verificar la conexión ds7
if ($conn2->connect_error) {
    die("Conexión fallida: " . $conn2->connect_error);
}



// Consulta SQL para insertar el RUT en la base de datos
$sql = "INSERT INTO bdcl28.lista_negra (rut, ruteje, telefono, glosa, fecha, status) VALUES ('$rut','99999999-9', '$fono','bloqueo_fono','$fecha','interno')";
$sql4 = "INSERT INTO bdcl30.lista_negra (rut, ruteje, telefono, glosa, fecha, status) VALUES ('$rut','99999999-9', '$fono','bloqueo_fono','$fecha','interno')";
$sql2 = "INSERT IGNORE INTO vicidial_dnc (phone_number) VALUES ('$fono')";
$sql3 = "INSERT INTO vicidial_dnc_log (phone_number, campaign_id, action, action_date, user) VALUES ('$fono','-SYSINT-', 'add','$fecha','6666')";



if ($conn->query($sql) === TRUE && $conn2->query($sql2) === TRUE && $conn2->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
    echo '<script language="javascript">alert("Registro guardado exitosamente.");</script>'; 
} else {
    echo '<script language="javascript">alert("Error al guardar el registro.");</script>' . $conn->error;
}
header("refresh:0;url=../../view/dashboard.php");
// Cerrar la conexión a la base de datos
$conn->close();
$conn2->close();
?>
