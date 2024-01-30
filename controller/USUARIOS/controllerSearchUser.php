<?php
include('../config/conexionBD.php');

session_start();

// Acceder a las variables almacenadas en la sesión
$usu_usuario = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$usu_rut = isset($_SESSION['usu_id']) ? $_SESSION['usu_id'] : '';
$rol = isset($_SESSION['idroles']) ? $_SESSION['idroles'] : '';
$idgrupo = isset($_SESSION['idgrupo']) ? $_SESSION['idgrupo'] : '';
$email = isset($_SESSION['Correo']) ? $_SESSION['Correo'] : '';
// Verificar si el usuario ha iniciado sesión
if (empty($_SESSION['usu_id']) || empty($_SESSION['idroles'])) {
  // El usuario no ha iniciado sesión o falta información en la sesión, redirigir a la página de inicio de sesión
  header("Location: ../index.php");
  exit();
}



  // Código para el dashboard de usuario
  $query1 = "SELECT e.nombreEmpresas, a.estado 
            FROM Empresas e 
            INNER JOIN Asignacion a ON e.idEmpresas = a.Empresa_idEmpresa 
            WHERE a.Usuarios_idUsuarios = $usu_rut AND a.estado = 1
            ORDER BY e.nombreEmpresas ASC";


// Resto del código aquí...

// Ejecutar la consulta
$result1 = $conn->query($query1);

// Verificar si la consulta fue exitosa
if (!$result1) {
  die("Error al ejecutar la consulta SQL: " . $conn->error);
}

// Resto del código aquí...
?>