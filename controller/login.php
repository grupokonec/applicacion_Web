<?php
include("../config/conexionBD.php");

$usu_usuario = isset($_POST['usu_usuario']) ? $_POST['usu_usuario'] : '';
$usu_clave = isset($_POST['usu_clave']) ? $_POST['usu_clave'] : '';

try {
    // Iniciar sesión
    session_start();

    // Realizar la consulta a la tabla Usuarios
    $sql = "SELECT Rut, Contraseña, Nombre, Correo, idroles,idgrupo FROM Usuarios WHERE Rut = :usu_usuario AND Contraseña = :usu_clave";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usu_usuario', $usu_usuario);
    $stmt->bindParam(':usu_clave', $usu_clave);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // El usuario existe en la tabla Usuarios
        $_SESSION['usu_id'] = $row['Rut'];
        $_SESSION['name'] = $row['Nombre'];
        $_SESSION['Correo'] = $row['Correo'];
        $_SESSION['idroles'] = $row['idroles'];
        $_SESSION['idgrupo'] = $row['idgrupo'];
    } else {
        // Si no se encontró en Usuarios, buscar en Ejecutivos
        $sql = "SELECT Rut, Contraseña, Nombre, Correo, idroles,idgrupo FROM Ejecutivos WHERE Rut = :usu_usuario AND Contraseña = :usu_clave";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usu_usuario', $usu_usuario);
        $stmt->bindParam(':usu_clave', $usu_clave);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // El usuario existe en la tabla Ejecutivos
            $_SESSION['usu_id'] = $row['Rut'];
            $_SESSION['name'] = $row['Nombre'];
            $_SESSION['Correo'] = $row['Correo'];
            // Asumiendo que la columna 'idroles' también existe en Ejecutivos y está relacionada correctamente
            $_SESSION['idroles'] = $row['idroles']; 
            $_SESSION['idgrupo'] = $row['idgrupo']; 
        } else {
            // El usuario no existe en ninguna de las tablas
            echo "Usuario no existe en ninguna tabla";
        }
    }

    if (isset($_SESSION['usu_id'])) {
        // Usuario encontrado, redirigir o realizar acciones adicionales
        echo "success"; // Reemplazar con la página de destino
        exit;
    }

} catch (PDOException $e) {
    echo 'Error al conectarse con la base de datos: ' . $e->getMessage();
    exit;
}
?>
