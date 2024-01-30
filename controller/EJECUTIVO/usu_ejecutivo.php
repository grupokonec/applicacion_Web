<?php

require("../../config/conexionBD.php");

$rut = $_POST['usu_rut'];
$nombre = $_POST['usu_usu'];
$correo = $_POST['correo'];
$contraseña = $_POST['usu_pass'];
$rut_supervisor = $_POST['superv'];

// Consulta SQL utilizando sentencia preparada
$sql = "INSERT INTO Ejecutivos (Rut, Nombre, Contraseña, Correo, idsuper) VALUES (:rut, :nombre, :contrasena, :correo, :rut_supervisor)";
$stmt = $conn->prepare($sql);

// Enlazar parámetros
$stmt->bindParam(':rut', $rut);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':contrasena', $contraseña);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':rut_supervisor', $rut_supervisor);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo 'El usuario fue creado';
} else {
    echo 'El usuario no pudo ser creado: ' . $stmt->errorInfo()[2];
}

$stmt->closeCursor();  // Cerrar la sentencia preparada

?>
