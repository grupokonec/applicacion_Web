<?php
$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "report00";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Obtener el valor actual de 'active' para el usuario con el ID dado
    $selectQuery = "SELECT active FROM users WHERE id = ?";
    $stmtSelect = $conn->prepare($selectQuery);

    if ($stmtSelect) {
        $stmtSelect->bind_param('s', $id);
        $stmtSelect->execute();
        $stmtSelect->bind_result($currentActive);

        // Obtener el valor actual y calcular el nuevo valor (inversión)
        if ($stmtSelect->fetch()) {
            $newActive = ($currentActive == 1) ? 0 : 1;

            // Cerrar el resultado de la consulta SELECT antes de preparar la consulta UPDATE
            $stmtSelect->close();
        
            // Actualizar el campo 'active' en la tabla 'users' para el usuario con el ID dado
            $updateQuery = "UPDATE users SET active = ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
        
            if ($stmtUpdate) {
                $stmtUpdate->bind_param('ss', $newActive, $id);
        
                if ($stmtUpdate->execute()) {
                    echo "Campo 'active' actualizado correctamente.";
                    header("location: ../../view/dashboard.php");
                    exit();
                } else {
                    echo "Error al ejecutar la consulta UPDATE: " . $stmtUpdate->error;
                }
        
                $stmtUpdate->close();
            } else {
                echo "Error en la preparación de la consulta UPDATE: " . $conn->error;
            }
        } else {
            echo "Error al obtener el valor actual de 'active': " . $stmtSelect->error;
        }
    } else {
        echo "Error en la preparación de la consulta SELECT: " . $conn->error;
    }
}

$conn->close();
?>
