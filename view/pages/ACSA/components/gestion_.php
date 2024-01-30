<style>
    /* Estilo para hacer que la columna sea redimensionable */
    .resizable-column {
        resize: horizontal; /* Permite la redimensión horizontal */
        overflow: auto; /* Hace que el contenido adicional sea desplazable */
        word-wrap: break-word; /* Permite el ajuste de palabras al cambiar el tamaño */
        max-width: 150px; /* Ancho máximo inicial */
    }
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rut'])) {
    $rut = $_POST['rut'];

    // Conexión a la base de datos
    $servername = "35.226.0.51";
    $username = "root";
    $password = "kon.dat00,55+";
    $dbname = "bdcl11";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Usar una declaración preparada para evitar la inyección SQL
    $sql = "SELECT * FROM all_contacts WHERE rut = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rut); // "s" indica que $rut es una cadena (string)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mostrar resultados en una tabla con la estructura proporcionada
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered '>";
        echo "<thead><tr>
            <th style='font-size:80%;'>Rut</th>
            <th style='font-size:80%;'>Ejecutivo</th>
            <th style='font-size:80%;'>Telefono</th>
            <th style='font-size:80%; width: 150px; max-width: 150px;  class='resizable-column' >Glosa</th>
            <th style='font-size:80%;'>Fecha</th>
            <th style='font-size:80%;'>Respuesta</th>
            <th style='font-size:80%;'>Tipo</th>
            </tr>
            </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td style='font-size:80%;'>" . $row["rut"] . "</td>
                    <td style='font-size:80%;'>" . $row["ruteje"] . "</td>
                    <td style='font-size:80%;'>" . $row["telefono"] . "</td>
                    <td style='font-size:80%; width: 150px; max-width: 150px'; class='resizable-column'>" . $row["glosa"] . "</td>
                    <td style='font-size:80%;'>" . $row["fecha"] . "</td>
                    <td style='font-size:80%;'>" . $row["respuesta"] . "</td>
                    <td style='font-size:80%;'>" . $row["tipo"] . "</td>
                    </tr>";
        }
        echo "</tbody>
            </table>";
        echo "</div>";
    } else {
        // Mostrar mensaje si no se encuentra el cliente
        echo "<p>No se encontró el cliente.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>


