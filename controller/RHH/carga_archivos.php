<?php

function listarDirectorios($dir)
{
    $resultados = [];
    if (is_dir($dir)) {
        $elementos = array_diff(scandir($dir), array('..', '.'));

        foreach ($elementos as $elemento) {
            $rutaCompleta = $dir . '/' . $elemento;
            if (is_dir($rutaCompleta)) {
                // Si es un directorio, llama recursivamente para obtener sus hijos
                $resultados[] = [
                    'nombre' => $elemento,
                    'tipo' => 'carpeta',
                    'hijos' => listarDirectorios($rutaCompleta)
                ];
            } else {
                // Si es un archivo, simplemente añádelo al array de resultados
                $resultados[] = [
                    'nombre' => $elemento,
                    'tipo' => 'archivo'
                ];
            }
        }
    } else {
        echo "La ruta proporcionada no es un directorio válido.";
        return [];
    }

    return $resultados;
}

$directorioRaiz = realpath('../../Archivos_HRR');
if ($directorioRaiz === false) {
    die("Error: El directorio no existe.");
}

$estructura = listarDirectorios($directorioRaiz);

echo json_encode($estructura);

?>