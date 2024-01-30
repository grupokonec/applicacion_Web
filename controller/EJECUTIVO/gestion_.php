<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rut'])) {
    $rut = $_POST['rut'];

    // Conexión a la base de datos
    $servername = "35.226.0.51";
    $username = "root";
    $password = "kon.dat00,55+";
    $dbname = "konexnet";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM c_vsur WHERE rut = '$rut'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar resultados en una tabla con estructura proporcionada
        echo "<table class='table table-bordered'>";
        echo "<thead><tr>
                    <th style='font-size:80%;'>Rut</th>
                    <th style='font-size:80%;'>Nombre</th>
                    <th style='font-size:80%;'>Email</th>
                    <th style='font-size:80%;'>Enviar Correo</th>
                    </tr>
                    </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td style='font-size:80%;'>" . $row["rut"] . "</td>
                        <td style='font-size:80%;'>" . $row["nombre"] . " " . $row["ap_paterno"] . " " . $row["ap_materno"] . "</td>
                        <td style='font-size:80%;'>" . $row["correo"] . "</td>
                        <td style='font-size:80%;'>
                        <form method='POST' action='../controller/EJECUTIVO/correo_crm.php'>
                            <input type='hidden' name='rut' value='" . $row["rut"] . "'>
                            <input type='hidden' name='nombre' value='" . $row["nombre"] . " " . $row["ap_paterno"] . " " . $row["ap_materno"] . "'>
                            <input type='hidden' name='correo' value='" . $row["correo"] . "'>
                            <button type='submit' class='btn-save btn btn-info btn-sm' name='enviarCorreo' id='enviarCorreo'>ENVIAR</button>
                        </form>
                        </td>
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