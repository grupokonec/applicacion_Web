<?php
session_start();

if (isset($_GET['close'])) {
  // Destruir la sesión
  session_destroy();
  
  // Redirigir a la página principal
  header("Location: ../index.php");
  exit();
}

// Otro contenido de tu script PHP, si es necesario
?>
