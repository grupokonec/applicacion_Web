<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
     // Valor predeterminado
    $rut = $_POST["rut0"];
    $nombre = $_POST["nombre0"];
    $contrasena = $_POST["contra"];
    

    // Realizar la inserción en la base de datos
    $servername = "35.226.0.51";
    $username = "root";
    $password = "kon.dat00,55+";
    $database = "report00";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "UPDATE users SET id=?, name=?, password=? WHERE id=?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error de preparación de consulta: " . $conn->error);
    }

    $stmt->bind_param("ssss", $rut, $nombre, $contrasena, $rut);

    $stmt->execute();

    // Verificar si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "Usuario modificado exitosamente.";
        // Redirigir después de la ejecución
        header("Location: ../../view/dashboard.php");
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
