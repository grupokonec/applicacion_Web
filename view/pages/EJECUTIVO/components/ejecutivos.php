<?php
include("../../../../config/conexionBD.php");

$supervisor = $_GET['superv'];


// Consulta SQL para obtener datos de la tabla Ejecutivos
if ($supervisor == 9999) {
    # code...
    $sql = "SELECT Rut, Nombre, Correo FROM Ejecutivos";
}else{
    $sql = "SELECT Rut, Nombre, Correo FROM Ejecutivos where idsuper= '$supervisor'";
}


$result = $conn->query($sql);

?>


<div class="table-responsive" >
    <!-- Contenido del segundo div -->
    <h3>Usuarios</h3>

    <!-- Tabla con cabeceras de rut, nombre y correo -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterar sobre los resultados y mostrarlos en la tabla
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['Rut']}</td>";
                echo "<td>{$row['Nombre']}</td>";
                echo "<td>{$row['Correo']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Cerrar la conexión después de haber utilizado los datos
    $conn = null;
    ?>
</div>
