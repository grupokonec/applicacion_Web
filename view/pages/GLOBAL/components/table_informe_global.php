<?php


if (isset($_POST['resultArray'])) {
    // Recibe los datos del formulario AJAX y decodifica la cadena JSON
    $resultArray = json_decode($_POST['resultArray']);



    // Verificar si la decodificación fue exitosa y si $resultArray es un array u objeto
    if ($resultArray !== null && json_last_error() === JSON_ERROR_NONE && (is_array($resultArray) || is_object($resultArray))) {
        // Mostrar la tabla solo si la matriz no está vacía
        if (!empty($resultArray)) {
            echo '<div class="table-responsive">';
            echo '<h3>Cantidad De Email En Carteras</h3>';
            echo '<table class="table table-bordered table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>campana</th>';
            echo '<th>detalle</th>';
            echo '<th>empresa</th>';
            echo '<th>fecha</th>';
            echo '<th>medio</th>';
            echo '<th>paleta Email</th>';
            echo '<th>rut</th>';
            echo '<th>tipo_cobranza</th>';
            echo '<th>tipo_gestion</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Iterar sobre los resultados y mostrarlos en la tabla
            foreach ($resultArray as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row->campana) . '</td>';
                echo '<td>' . htmlspecialchars($row->detalle) . '</td>';
                echo '<td>' . htmlspecialchars($row->empresa) . '</td>';
                echo '<td>' . htmlspecialchars($row->fecha) . '</td>';
                echo '<td>' . htmlspecialchars($row->medio) . '</td>';
                echo '<td>' . htmlspecialchars($row->paleta) . '</td>';
                echo '<td>' . htmlspecialchars($row->rut) . '</td>';
                echo '<td>' . htmlspecialchars($row->tipo_cobranza) . '</td>';
                echo '<td>' . htmlspecialchars($row->tipo_gestion) . '</td>';
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
} else {
    echo '<div class="table-responsive">';
    echo '<h3>Carteras</h3>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Prefix</th>';
    echo '<th>Cantidad Email</th>';
    echo '</tr>';
    echo '</thead>';
    echo '</table>';
    echo '</div>';
}
?>