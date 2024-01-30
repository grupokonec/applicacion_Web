<?php

require_once '../vendor/autoload.php';

use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;

$host = 'sftp.konecsys.com';
$username = 'cnorte';
$privateKeyPath = __DIR__ . '/cn.pem';
$remoteDirectory = '/entrada'; // Cambia esto según tu estructura de directorios remotos

// Establecer la fecha de prueba (20231117)
$testDate = '20231201';




$VICIDIAL_SFTP_HOST= '192.168.1.126' ;
$VICIDIAL_SFTP_USER='root';
$VICIDIAL_SFTP_PASS='hola123';



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

    // Construir el nombre del archivo esperado para CN_DTS_COB_77 (CN_DTS_COB_77_YYYYMMDD)
    $expectedFileName77 = 'CN_DTS_COB_77_' . $testDate;

    // Construir el nombre del archivo esperado para CN_DTS_COB_76 (CN_DTS_COB_76_YYYYMMDD)
    $expectedFileName76 = 'CN_DTS_COB_76_' . $testDate;

    // Listar archivos en el directorio remoto /entrada
    $files = $sftp->nlist($remoteDirectory);

    // Filtrar archivos que coincidan con el nombre esperado para CN_DTS_COB_77
    $matchingFiles77 = array_filter($files, function ($file) use ($expectedFileName77) {
        return strpos($file, $expectedFileName77) !== false;
    });
    $desac = __DIR__ . '/desactivacion.dit';
     // Obtener el contenido de los archivos CN_DTS_COB_77
     foreach ($matchingFiles77 as $file) {
        $fileContent = $sftp->get($remoteDirectory . '/' . $file);

        // Puedes ajustar el delimitador según el formato real de tus archivos
        $delimiter = ','; 

        // Construir la consulta de importación utilizando la plantilla desactivacion.dit
        $importTemplate = file_get_contents($desac);

        // Reemplazar valores específicos en la plantilla
        $importTemplate = str_replace('<PropertyValue Name="ConnectionName" xml:space="preserve">35.226.0.51</PropertyValue>', '<PropertyValue Name="ConnectionName" xml:space="preserve">' . $host . '</PropertyValue>', $importTemplate);
        $importTemplate = str_replace('<PropertyValue Name="ConnectionString" xml:space="preserve">User Id=root;Host=35.226.0.51;Character Set=utf8</PropertyValue>', '<PropertyValue Name="ConnectionString" xml:space="preserve">User Id=' . $username . ';Host=' . $host . ';Character Set=utf8</PropertyValue>', $importTemplate);
        $importTemplate = str_replace('<PropertyValue Name="TargetTable" xml:space="preserve">bdcl28.update_desactivacion</PropertyValue>', '<PropertyValue Name="TargetTable" xml:space="preserve">pba</PropertyValue>', $importTemplate);
        $importTemplate = str_replace('<PropertyValue Name="FileName" xml:space="preserve">C:\CN\CN_DTS_COB_prueba_20221011.txt</PropertyValue>', '<PropertyValue Name="FileName" xml:space="preserve">' . $remoteDirectory . '/' . $file . '</PropertyValue>', $importTemplate);
        $importTemplate = str_replace('<PropertyValue Name="Delimiter" xml:space="preserve">&#x0;</PropertyValue>', '<PropertyValue Name="Delimiter" xml:space="preserve">' . $delimiter . '</PropertyValue>', $importTemplate);
        // ... (Reemplazar otros valores según sea necesario)

        // Guardar la plantilla modificada en un archivo temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'import_template');
        file_put_contents($tempFile, $importTemplate);

        // Ejecutar la importación utilizando dbForge (reemplaza 'dbforge_executable' con el nombre real del ejecutable de dbForge)
        exec('dbforge_executable -importTemplate ' . $tempFile);

        // Eliminar el archivo temporal
        unlink($tempFile);
    }

      // Cerrar la conexión
      $sftp->disconnect();

    // Cerrar la conexión
    $sftp->disconnect();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();


}

?>

