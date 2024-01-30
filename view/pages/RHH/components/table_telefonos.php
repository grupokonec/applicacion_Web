<?php
if (isset($_POST['resultArray'])) {
    // Recibe los datos del formulario AJAX y decodifica la cadena JSON
    $resultArray = json_decode($_POST['resultArray']);

    // Verificar si la decodificación fue exitosa y si $resultArray es un array u objeto
    if ($resultArray !== null && json_last_error() === JSON_ERROR_NONE && (is_array($resultArray) || is_object($resultArray))) {
        // Mostrar la tabla solo si la matriz no está vacía
        if (!empty($resultArray)) {
            echo '<div class="table-responsive">';
            echo '<h3>Cantidad de Telefonos</h3>';
            echo '<table class="table table-bordered table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Prefix</th>';
            echo '<th>Llamadas</th>';
            echo '<th>minutos</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Iterar sobre los resultados y mostrarlos en la tabla
            foreach ($resultArray as $row) {
                echo '<td>' . htmlspecialchars($row->campaign_id) . '</td>';
                echo '<td>' . htmlspecialchars($row->llamadas) . '</td>';
                echo '<td>' . htmlspecialchars($row->minutos) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>La matriz de resultados está vacía.</p>';
        }
    } else {
        // Imprimir mensaje de error si la decodificación falló o $resultArray no es un array u objeto
        echo '<p>Error al decodificar la cadena JSON o $resultArray no es un array u objeto.</p>';
    }
}
?>
