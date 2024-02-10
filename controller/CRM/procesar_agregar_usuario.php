<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $idempresa = 1; // Valor predeterminado
    $rut = trim($_POST["rut"]);
    $nombre = trim($_POST["nombre"]);
    $contrasena = trim($_POST["contra"]);
    $nivel = 1; // No es necesario trim() ya que es un valor predeterminado
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


    // Preparar la consulta para verificar si el RUT ya existe
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $rut);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el RUT ya existe, mostrar mensaje y terminar script
        echo "<script>alert('Usuario ya existe en la base de datos.'); window.location = '../../view/dashboard.php';</script>";
        $stmt->close();
        $conn->close();
        exit();
    } else {
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
            header("Location: ../../view/dashboard.php");
            exit();
        } else {
            echo "Error al agregar usuario: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirigir en caso de acceso directo al script sin enviar datos del formulario
    header("Location: ../../view/dashboard.php");
    exit();
}
