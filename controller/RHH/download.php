<?php

$basePath = realpath('../../Archivos_HRR');

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = realpath($basePath . '/' . $file);

    // Seguridad: Verificar que el archivo está dentro del directorio permitido
    if ($filePath !== false && strpos($filePath, $basePath) === 0 && file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "No se puede acceder al archivo solicitado.";
    }
} else {
    echo "No se especificó ningún archivo para descargar.";
}
?>
