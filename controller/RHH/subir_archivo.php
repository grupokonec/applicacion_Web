<?php

// Define el directorio raíz desde donde se permitirá acceder a las subcarpetas
$directorioRaiz = realpath('../../Archivos_HRR');

if (!empty($_FILES) && isset($_POST['rutaCarpeta'])) {
    // Construye la ruta completa de la carpeta destino
    $rutaCarpetaRelativa = $_POST['rutaCarpeta'];
    $rutaCarpetaCompleta = realpath($directorioRaiz . '/' . $rutaCarpetaRelativa);

    // Verifica que la ruta de la carpeta destino esté dentro del directorio raíz permitido
    if (strpos($rutaCarpetaCompleta, $directorioRaiz) === 0 && is_dir($rutaCarpetaCompleta)) {
        // Iterar sobre todos los archivos
        foreach ($_FILES as $archivo) {
            $destino = $rutaCarpetaCompleta . '/' . basename($archivo['name']);

            // Mover el archivo del directorio temporal al destino final
            if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                echo "Archivo subido con éxito: " . htmlspecialchars($archivo['name'], ENT_QUOTES, 'UTF-8') . "\n";
            } else {
                echo "Error al subir el archivo: " . htmlspecialchars($archivo['name'], ENT_QUOTES, 'UTF-8') . "\n";
            }
        }
    } else {
        echo "La operación no está permitida. La carpeta destino está fuera del directorio raíz.";
    }
} else {
    echo "No se recibieron archivos o falta información.";
}
?>
