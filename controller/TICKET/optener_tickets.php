<?php
include("../../config/conexionGlobal.php"); // Asegúrate de cambiar esto por la ruta correcta a tu archivo Connex

// Crear una instancia de la clase Connex para establecer la conexión
$connecion = new Connex("35.226.0.51", "konexnet", "root", "kon.dat00,55+");

// La consulta SQL que quieres ejecutar
$query = "";

// Ejecutar la consulta
try {
    $stmt = $connecion->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   $result=[
    "today"=>$data
   ] ;


   echo json_encode($result);

} catch (Exception $e) {
    // Manejar el error
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión (opcional, ya que PHP lo hace automáticamente al finalizar el script)
$connecion->close();
?>
