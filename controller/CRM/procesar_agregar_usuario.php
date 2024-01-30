<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $idempresa = 1; // Valor predeterminado
    $rut = $_POST["rut"];
    $nombre = $_POST["nombre"];
    $contrasena = $_POST["contra"];
    $nivel = 1;
    $activo = 1;
    


    // Obtener la fecha actual
    date_default_timezone_set('America/Santiago');
    $fecha_ing = date("Y-m-d H:i:s");  // Formato "YYYY-MM-DD HH:MM:SS"

    // Realizar la inserción en la base de datos
    $servername = "35.226.0.51";
    $username = "root";
    $password = "kon.dat00,55+";
    $database = "report00";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "INSERT INTO users (idempresa, id, name, password, level, active, fecha_ing) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error de preparación de consulta: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $idempresa, $rut, $nombre, $contrasena, $nivel, $activo, $fecha_ing);

    $stmt->execute();

    // Verificar si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "Usuario agregado exitosamente.";
        // Redirigir después de la ejecución
        header("Location: ../view/dashboard.php");
        exit();
    } else {
        echo "Error al agregar usuario: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    // Redirigir en caso de acceso directo al script sin enviar datos del formulario
    header("Location: ../view/dashboard.php");
    exit();
}
?>
