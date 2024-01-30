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
        $dbname = "bdcl22";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Conexión a la base de datos ds2!!!!!MODIFICAR
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
            case "cartera":
                $nombre_archivo = "cartera_actual.csv";
                $sql = "SELECT * FROM cartera_totales";
                $result = $conn->query($sql);
                break;
            case "pagos":
                $nombre_archivo = "Informe_Pagos_AVO.csv";
                $sql = "SELECT * FROM pagos";
                $result = $conn->query($sql);
                break;
            case "Bloqueados":
                $nombre_archivo = "Bloqueados.csv";
                // Llamar al primer procedimiento almacenado
                $sql = "SELECT * FROM bloqueados";


                $result = $conn->query($sql);

                break;
            case "Lista_Negra_Email":
                $nombre_archivo = "LN_Email.csv";
                // Llamar al primer procedimiento almacenado
                $sql = "SELECT * FROM lista_negra_email";


                $result = $conn->query($sql);

                break;
            case "Asignados":
                $nombre_archivo = "Asignados.csv";
                // Llamar al primer procedimiento almacenado
                $sql = "SELECT * FROM asignacion_ejecutivos";


                $result = $conn->query($sql);

                break;
            case "Recupero":
                $nombre_archivo = "Recupero.csv";
                // Llamar al primer procedimiento almacenado
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
        }

        $conn->close();
        $conn2->close();
    } else {
        echo "Por favor, seleccione un tipo de informe.";
    }
}
?>
