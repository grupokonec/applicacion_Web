<?php

require_once '../vendor/autoload.php';

use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;

$host = 'sftp.konecsys.com';
$username = 'cnorte';
$privateKeyPath = __DIR__ . '/cn.pem';
$remoteDirectory = '/entrada'; // Cambia esto según tu estructura de directorios remotos
// Establecer la fecha de prueba (20231117)
//$testDate = '20231119';

$hostAcsa = 'sftp.konecsys.com';
$usernameAcsa = 'acentral';
$privateKeyPathAcsa = __DIR__ . '/acentral.pem';
$remoteDirectoryAcsa = '/2023'; // Cambia esto según tu estructura de directorios remotos
// Establecer la fecha de prueba (20231117)
//$testDate = '20231119';



//archivos de ACSA----------------------------------------------------------------------------------
try {
    $sftp1 = new SFTP($hostAcsa);

    // Conectar con clave privada
    $key = new RSA();
    $key->loadKey(file_get_contents($privateKeyPathAcsa));

    if (!$sftp1->login($usernameAcsa, $key)) {
        throw new Exception('SFTP login falló.');
    }

    // Obtener el número del día de la semana (1 para lunes, 2 para martes, etc.)
    $currentDay = date('N');

    if ($currentDay >= 1 && $currentDay <= 5) {
        // Resto del código...

       // ...
// Obtener la fecha en formato "día mes año" (27112023)
$formattedDate = date('dmY');

// Construir el nombre del archivo esperado para BDD_Descuentos_Diarios
$BDDDescuentosDiarios01 = 'BDD_Descuentos_Diarios_' . $formattedDate;

// Construir el nombre del archivo esperado para REF_KON3CTADOS
$REFymdKON3CTADOS = 'REF_' . $formattedDate . '_KON3CTADOS';

if ($currentDay >= 1 && $currentDay <= 5) {
    // Resto del código...
    
    // Listar archivos en el directorio remoto /2023
    $files1 = $sftp1->nlist($remoteDirectoryAcsa);

    // Filtrar archivos que coincidan con el nombre esperado para BDD_Descuentos_Diarios
    $BDDDescuentosDiariosAcsa = array_filter($files1, function ($file) use ($BDDDescuentosDiarios01) {
        return strpos($file, $BDDDescuentosDiarios01) !== false;
    });

    // Filtrar archivos que coincidan con el nombre esperado para REF_KON3CTADOS
    $REFymdKON3CTADOSAcsa = array_filter($files1, function ($file) use ($REFymdKON3CTADOS) {
        return strpos($file, $REFymdKON3CTADOS) !== false;
    });


} 




// ...

    } else {
        echo 'Hoy no es un día laborable.';
    }

} catch (\Throwable $th) {
    echo 'Error: ' . $th->getMessage();
}



//---------------------------------------------------------------------------------------------------------------








try {
    // Verificar la existencia de la clave privada
    if (!file_exists($privateKeyPath)) {
        throw new Exception('La clave privada no existe en la ruta proporcionada.');
    }

    // Crear una instancia de SFTP
    $sftp = new SFTP($host);

    // Conectar con clave privada
    $key = new RSA();
    $key->loadKey(file_get_contents($privateKeyPath));

    if (!$sftp->login($username, $key)) {
        throw new Exception('SFTP login fallo.');
    }

    // Verificar si es un día laborable (lunes a viernes)
    $currentDay = date('N');
   if ($currentDay >= 1 && $currentDay <= 5) {
        // Construir el nombre del archivo esperado para CN_DTS_COB_77 (CN_DTS_COB_77_YYYYMMDD)
        $expectedFileName77 = 'CN_DTS_COB_77_' .date('Ymd');

        // Construir el nombre del archivo esperado para CN_DTS_COB_76 (CN_DTS_COB_76_YYYYMMDD)
        $expectedFileName76 = 'CN_DTS_COB_76_' . date('Ymd');

        // Listar archivos en el directorio remoto /entrada
        $files = $sftp->nlist($remoteDirectory);

        // Filtrar archivos que coincidan con el nombre esperado para CN_DTS_COB_77
        $matchingFiles77 = array_filter($files, function ($file) use ($expectedFileName77) {
            return strpos($file, $expectedFileName77) !== false;
        });

        // Filtrar archivos que coincidan con el nombre esperado para CN_DTS_COB_76
        $matchingFiles76 = array_filter($files, function ($file) use ($expectedFileName76) {
            return strpos($file, $expectedFileName76) !== false;
        });

      


          // Buscar la carpeta "AVS Desactivacion"
    $avsDesactivacionDirectory = $remoteDirectory . '/AVS Desactivacion';
    $avsDesactivacionFiles = $sftp->nlist($avsDesactivacionDirectory);

    // Construir el nombre del archivo esperado para CN_DTS_COB_44 (CN_DTS_COB_44_YYYYMMDD)
    $expectedFileName44 = 'VS_DTS_COB_44_' . date('Ymd');

    // Construir el nombre del archivo esperado para CN_DTS_COB_45 (CN_DTS_COB_45_YYYYMMDD)
    $expectedFileName45 = 'VS_DTS_COB_45_' . date('Ymd');

    // Filtrar archivos que coincidan con el nombre esperado para CN_DTS_COB_44
    $matchingFiles44 = array_filter($avsDesactivacionFiles, function ($file) use ($expectedFileName44) {
        return strpos($file, $expectedFileName44) !== false;
    });

    // Filtrar archivos que coincidan con el nombre esperado para CN_DTS_COB_45
    $matchingFiles45 = array_filter($avsDesactivacionFiles, function ($file) use ($expectedFileName45) {
        return strpos($file, $expectedFileName45) !== false;
    });




    
    function convertTxtToCsv($sftp, $remoteDirectory, $txtFileName, $csvFileName) {
        // Obtener el contenido del archivo TXT
        $content = $sftp->get($remoteDirectory . '/' . $txtFileName);
    
        // Crear un puntero a un nuevo archivo CSV
        $csvFile = fopen($csvFileName, 'w');
    
        // Escribir la cabecera del CSV con nombres de columnas
        fputcsv($csvFile, [
            'Columna1',
            'Columna2',
            'Columna3',
            'Columna4',
            'Columna5',
            'Columna6',
            'Columna7',
            'Columna8',
        ], ';'); // Usar punto y coma como delimitador
    
        // Procesar el contenido del archivo TXT
        $lineLengths = [1, 10, 17, 12, 16, 2, 2, 8]; // Longitudes de columnas
        $startPosition = 0;
    
        while ($startPosition < strlen($content)) {
            $columns = [];
    
            // Dividir la línea en columnas utilizando las longitudes proporcionadas
            foreach ($lineLengths as $length) {
                $column = trim(substr($content, $startPosition, $length), " \t\n\r\0\x0B0");
                $columns[] = ($length > 1) ? ltrim($column, '0') : $column; // Eliminar ceros adicionales solo si la longitud es mayor que 1
                $startPosition += $length;
            }
    
            // Escribir la fila en el archivo CSV con punto y coma como delimitador
            fputcsv($csvFile, $columns, ';');
        }
    
        // Cerrar el archivo CSV
        fclose($csvFile);
    }
    
    // ...
    
    // Convertir archivos correspondientes a BDD_Descuentos_Diarios
    foreach ($matchingFiles77 as $txtFile) {
        $csvFileName = pathinfo($txtFile, PATHINFO_FILENAME) . '.csv';
        convertTxtToCsv($sftp, $remoteDirectory, $txtFile, $csvFileName);
    
        // Puedes realizar cualquier procesamiento adicional aquí
    }
    














































    
   } else {
       echo 'Hoy no es un día laborable.';
   }

    // Cerrar la conexión
    $sftp->disconnect();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>

<?php
// Mostrar tabla para VESPUCIO NORTE
echo '<h2> COSTANERA NORTE</h2>';

echo '<table class="table table-striped">';

foreach ($matchingFiles76 as $file) {
    // Verificar si el archivo existe
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell" style="width: 150px;">';
    if (isset($file)) {
        echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 400px;"></span>');
    }else{
        echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 400px;"></span>';
    }
    echo '</td></tr>';
}

foreach ($matchingFiles77 as $file) {
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell" style="width: 150px;">';
    // Verificar si el archivo existe
    if (isset($file)) {
        echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 400px;"></span>');
    }else{
        echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 400px;"></span>';
    }
    echo '</td></tr>';
}

echo '</table>';


// Mostrar tabla para COSTANERA NORTE
echo '<h2>VESPUCIO SUR</h2>';
echo '<table class="table table-striped">';

foreach ($matchingFiles44 as $file) {

    // Verificar si el archivo existe
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell">';
    if (isset($file)) {
        echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 400px;"></span>');
    }else{
        echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 400px;"></span>';
    }

    echo '</td></tr>';
}


foreach ($matchingFiles45 as $file) {
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell">';
   // Verificar si el archivo existe
   if (isset($file)) {

    echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 400px;"></span>');
}else{
    echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 400px;"></span>';
}
echo '</td></tr>';
}

echo '</table>';




// Mostrar tabla para COSTANERA NORTE
echo '<h2>ACSA</h2>';
echo '<table class="table table-striped">';

foreach ($BDDDescuentosDiariosAcsa as $file) {

    // Verificar si el archivo existe
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell">';
    if (isset($file)) {
        echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 358px;"></span>');
    }else{
        echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 358px;"></span>';
    }

    echo '</td></tr>';
}


foreach ($REFymdKON3CTADOSAcsa as $file) {
    echo '<tr class="jsgrid-row"><td class="jsgrid-cell">';
   // Verificar si el archivo existe
   if (isset($file)) {

    echo ($file . ' <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: green; margin-left: 400px;"></span>');
}else{
    echo '- <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; margin-left: 400px;"></span>';
}
echo '</td></tr>';
}

echo '</table>';





?>





