<?php
set_time_limit(600);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha seleccionado un tipo de informe
    if (isset($_POST['tipo_informe'])) {
        $tipo_seleccionado = $_POST['tipo_informe'];

        // Conexión a la base de datos
        $servername = "35.226.0.51";
        $username = "root";
        $password = "kon.dat00,55+";
        $dbname = "bdcl1";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Conexión a la base de datos ds2
        $servername = "54.144.201.11";
        $username = "cron";
        $password = "1234";
        $database = "asterisk";

        $conn2 = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión ds2
        if ($conn2->connect_error) {
            die("Conexión fallida: " . $conn2->connect_error);
        }

        // Generar consulta según el tipo de informe seleccionado con su nombre especifico
        switch ($tipo_seleccionado) {
            case "reporte_semanal":
                $nombre_archivo = "informe_semanal.csv";
                $sql = "SELECT * FROM vw_reporte_semanal";
                $result = $conn->query($sql);
                break;
            case "pagos":
                $nombre_archivo = "Informe_Pagos_global.csv";
                $sql = "SELECT * FROM pagos";
                $result = $conn->query($sql);
                break;
            case "bot":
                $nombre_archivo = "bot.csv";
                // Llamar al primer procedimiento almacenado
                $sql_proc_1 = "CALL insertar_fonos_bot()";
                $result_proc_1 = $conn->query($sql_proc_1);

                // Llamar al segundo procedimiento almacenado
                $sql_proc_2 = "CALL insertar_datos()";
                $result_proc_2 = $conn->query($sql_proc_2);

                // Verificar si ambos procedimientos se ejecutaron correctamente
                if ($result_proc_1 && $result_proc_2) {
                    // Consulta a la vista después de ejecutar los procedimientos almacenados
                    $sql = "SELECT * FROM bot_vnor";
                }
                $result = $conn->query($sql);
                break;
            case "inbound":
                $nombre_archivo = "inbound_historicos_auto.csv";
                $sql = "SELECT
                    vicidial_list.status,
                    vicidial_list.user,
                    vicidial_list.list_id,
                    vicidial_list.phone_number,
                    vicidial_list.security_phrase,
                    vicidial_list.entry_date
                  FROM vicidial_list
                  WHERE vicidial_list.security_phrase = 'AVO'
                  AND vicidial_list.list_id = 999";
                $result = $conn2->query($sql);
                break;
            case "cartera_totales":
                $nombre_archivo = "Cartera_totales_global.csv";  ///sii cnort vsur
                $sql = "SELECT * FROM cartera_totales";
                $result = $conn->query($sql);
                break;
            case "bloqueados": //cnort vsur
                $nombre_archivo = "Bloqueados_global.csv";
                $sql = "SELECT * FROM bloqueados";
                $result = $conn->query($sql);
                break;
            case "lista_negra": //vsur cnort
                $nombre_archivo = "Lista_negra_global.csv";
                $sql = "SELECT * FROM lista_negra WHERE status = 'AUTO' OR status = 'interno'";
                $result = $conn->query($sql);
                break;
            case "lista_negra_mail":
                $nombre_archivo = "Lista_negra_mail_global.csv";
                $sql = "SELECT * FROM lista_negra_email";
                $result = $conn->query($sql);
                break;
            case "asignados":
                $nombre_archivo = "asignados_global.csv";
                $sql = "SELECT * FROM asignacion_ejecutivos";
                $result = $conn->query($sql);
                break;
            case "recupero":
                $nombre_archivo = "Recupero_ejecutivo_global.csv";
                $sql = "SELECT * FROM recupero";
                $result = $conn->query($sql);
                break;
            default:
                echo "Tipo de informe no válido.";
                exit;
        }
        if ($result->num_rows > 0) {
            // Generar el archivo de descarga (CSV en este ejemplo)
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');

            // Configurar el delimitador para el archivo CSV
            $output = fopen('php://output', 'w');

            // Obtener los nombres de las columnas y escribir la cabecera en el archivo CSV
            $columns = [];
            while ($row = $result->fetch_assoc()) {
                $columns = array_keys($row);
                break;
            }
            fputcsv($output, $columns, ';'); // Cabecera

            // Escribir los datos en el archivo con el delimitador especificado
            mysqli_data_seek($result, 0); // Reiniciar el puntero del resultado
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, $row, ';');
            }
            fclose($output);
        } else {
            echo "No se encontraron resultados";
            header("refresh:2;url=../../view/dashboard.php");
        }

        $conn->close();
        $conn2->close();
    } else {
        echo "Por favor, seleccione un tipo de informe.";
    }
}
?>