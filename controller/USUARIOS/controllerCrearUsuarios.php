<?php

include("../config/conexionBD.php");


// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contraseña = $_POST['password'];

// Consulta SQL para insertar el RUT en la base de datos
$sql = "INSERT INTO konexnet(Rut,Nombre,Contraseña,Correo) VALUES ('$rut','$nombre','$contraseña',$correo)";


if ($conn->query($sql) === TRUE) {
    echo 'El usuario fue creado'; 
} else {
    echo 'El usuario no puedo ' . $conn->error;
}


?>