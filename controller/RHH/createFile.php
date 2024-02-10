<?php

// Asegúrate de definir tu directorio raíz aquí
$directorioRaiz = realpath('../../Archivos_HRR');

// Verificar si se recibieron los datos necesarios
if (isset($_POST['rutaBase']) && isset($_POST['nombreSubcarpeta'])) {
    // Construir la ruta completa de la nueva carpeta
    $rutaCompleta = $directorioRaiz . $_POST['rutaBase'] . '/' . $_POST['nombreSubcarpeta'];

    // Asegurarte de que la ruta completa sigue estando dentro del directorio raíz
    // para prevenir la creación de carpetas fuera de tu área designada (por seguridad)
    if (strpos($rutaCompleta, $directorioRaiz) === 0) {
        // Verificar si la carpeta ya existe
        if (!file_exists($rutaCompleta)) {
            // Intentar crear la carpeta
            if (mkdir($rutaCompleta, 0777, true)) {
                echo "La carpeta se ha creado exitosamente.";
            } else {
                echo "Error al crear la carpeta.";
            }
        } else {
            echo "La carpeta ya existe.";
        }
    } else {
        echo "Operación no permitida.";
    }
} else {
    echo "Información insuficiente para crear la carpeta.";
}

?>