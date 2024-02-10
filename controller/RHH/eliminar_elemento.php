<?php

$basePath = realpath('../../Archivos_HRR'); // Asegúrate de ajustar según tu estructura

// Cambio: Usar 'rutaElemento' y 'tipoElemento' para manejar tanto archivos como carpetas
if (isset($_POST['rutaElemento'], $_POST['tipoElemento'])) {
    $rutaElemento = $_POST['rutaElemento'];
    $tipoElemento = $_POST['tipoElemento']; // 'carpeta' o 'archivo'
    $rutaCompleta = realpath($basePath . '/' . $rutaElemento);

    // Verificar que el elemento esté dentro del directorio permitido y exista
    if ($rutaCompleta && strpos($rutaCompleta, $basePath) === 0) {
        if ($tipoElemento === "carpeta" && is_dir($rutaCompleta)) {
            // Utilizar una función recursiva para eliminar la carpeta y su contenido
            eliminarRecursivamente($rutaCompleta);
            echo "Carpeta eliminada.";
        } elseif ($tipoElemento === "archivo" && is_file($rutaCompleta)) {
            // Si es un archivo, simplemente eliminar el archivo
            unlink($rutaCompleta);
            echo "Archivo eliminado.";
        } else {
            echo "El elemento no coincide con el tipo especificado o no se encuentra.";
        }
    } else {
        echo "Operación no permitida o elemento no encontrado.";
    }
} else {
    echo "Datos incompletos para la eliminación.";
}

function eliminarRecursivamente($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $filePath = "$dir/$file";
        is_dir($filePath) ? eliminarRecursivamente($filePath) : unlink($filePath);
    }
    rmdir($dir);
}
?>
