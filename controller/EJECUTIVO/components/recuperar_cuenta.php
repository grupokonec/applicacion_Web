<?php
include('../../config/conexionBD.php');

// Verifica si el formulario ha sido enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $usu_rut = isset($_POST["usu_rut"]) ? $_POST["usu_rut"] : '';
    $usu_rut = isset($_POST["usu_usu"]) ? $_POST["usu_usu"] : '';
    $newPass = isset($_POST["newPass"]) ? $_POST["newPass"] : '';
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : '';
  
    if (empty($usu_rut) || empty($usu_rut) || empty($newPass) || empty($newPass) || empty($newPass)) {

        echo "Los campos están vacíos. Por favor, complete todos los campos.";

    }

    // Busca en la tabla Ejecutivo
    $queryEjecutivo = "SELECT COUNT(*) as count FROM Ejecutivos WHERE Rut = '$usu_rut' AND Nombre = '$usu_usu' AND Correo = '$correo'";
    $resultEjecutivo = $conn->query($queryEjecutivo);

    if ($resultEjecutivo) {
        $countEjecutivo = $resultEjecutivo->fetch(PDO::FETCH_ASSOC)['count'];

        if ($countEjecutivo > 0) {
            // El usuario existe en la tabla Ejecutivo
            $updateQuery = "UPDATE Ejecutivos SET Contraseña = '$newPass' WHERE Rut = '$usu_rut' AND Nombre = '$usu_usu' AND Correo = '$correo'";
            $conn->query($updateQuery);

            echo "Contraseña actualizada correctamente para un ejecutivo";
        } else {
            // El usuario no existe en la tabla Ejecutivo, busca en la tabla Usuarios
            $queryUsuarios = "SELECT COUNT(*) as count FROM Usuarios WHERE Rut = '$usu_rut' AND Nombre = '$usu_usu' AND Correo = '$correo'";
            $resultUsuarios = $conn->query($queryUsuarios);

            if ($resultUsuarios) {
                $countUsuarios = $resultUsuarios->fetch(PDO::FETCH_ASSOC)['count'];

                if ($countUsuarios > 0) {
                    // El usuario existe en la tabla Usuarios
                    $updateQuery = "UPDATE Usuarios SET Contraseña = '$newPass' WHERE Rut = '$usu_rut' AND Nombre = '$usu_usu' AND Correo = '$correo'";
                    $conn->query($updateQuery);

                    echo "Contraseña actualizada correctamente";
                } else {
                    echo "Usuario no encontrado ";
                }
            } else {
                echo "Error al ejecutar la consulta SQL en la tabla Usuarios";
            }
        }
    } else {
        echo "Error al ejecutar la consulta SQL en la tabla Ejecutivo";
    }
} else {
    // Maneja el caso en el que el formulario no fue enviado mediante POST
    echo "El formulario no ha sido enviado correctamente.";
}

// Cierra la conexión después de haber utilizado los datos
$conn = null;

?>

