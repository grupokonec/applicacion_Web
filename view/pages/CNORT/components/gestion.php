<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rut'])) {
    $rut = $_POST['rut'];

    // Conexión a la base de datos (actualiza con tus credenciales)
    $servername = "35.226.0.51";
    $username = "root";
    $password = "kon.dat00,55+";
    $dbname = "bdcl28";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM all_contacts WHERE rut = '$rut'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar resultados en una tabla con estructura proporcionada
        echo "<table class='table table-bordered '>";
        echo "<thead><tr>
                    <th style='font-size:80%;'>Rut</th>
                    <th style='font-size:80%;'>Ejecutivo</th>
                    <th style='font-size:80%;'>Telefono</th>
                    <th style='font-size:80%;'>Glosa</th>
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
                        <td style='font-size:80%;'>" . $row["glosa"] . "</td>
                        <td style='font-size:80%;'>" . $row["fecha"] . "</td>
                        <td style='font-size:80%;'>" . $row["respuesta"] . "</td>
                        <td style='font-size:80%;'>" . $row["tipo"] . "</td>
                        </tr>";
        }
        echo "</tbody>
                    </table>";
    } else {
        // Mostrar mensaje si no se encuentra el cliente
        echo "<p>No se encontró el cliente.</p>";
    }

    $conn->close();
}
?>