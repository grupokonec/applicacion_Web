<?php
$servername = "52.54.246.25";
$username = "cron";
$password = "1234";
$database = "test";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    $query = "SELECT * FROM audios_final";
}

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


?>


<div class="card">
    <div class="card-body">
        <h4 class="card-title">Audios TACH</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr class="<?php echo $counter % 2 == 0 ? 'even' : 'odd'; ?>">
                                <th scope="col">#</th>
                                <th scope="col">Descargar Audio</th>
                                <th scope="col">RUT_Cliente</th>
                                <th scope="col">RUT_ejecutivo</th>
                                <th scope="col">Nombre_ejecutivo</th>
                                <th scope="col">N° de caso</th>
                                <th scope="col">Inicio de llamada</th>
                                <th scope="col">Tipificacion</th>
                                <th scope="col">Cuenta Sau</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 1; // Inicializamos el contador
                            
                            try {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                    <th scope='row'>" . $counter . "</th>
                                                    <td><a href='" . htmlspecialchars($row["link"]) . "' download><center><i class='fa fa-cloud-download'></i></center></a></td>
                                                    <td>" . $row["rut_cliente"] . "</td>
                                                    <td>" . $row["ruteje"] . "</td>
                                                    <td>" . $row["nombreeje"] . "</td>
                                                    <td>" . $row["caso"] . "</td>
                                                    <td>" . $row["incio_call"] . "</td>
                                                    <td>" . $row["tipificacion"] . "</td>
                                                    <td>" . $row["cuenta_sau"] . "</td>
                                                  </tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No hay usuarios en la base de datos</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- endinject -->
<!-- Plugin js for this page -->
<script src="../assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="../assets/vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->

<!-- endinject -->
<!-- Custom js for this page -->
<script src="../assets/js/shared/data-table-tach.js"></script>