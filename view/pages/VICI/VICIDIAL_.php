<?php
$servername = "54.87.109.210";
$username = "cron";
$password = "1234";
$database = "asterisk";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    $query = "SELECT * FROM vicidial_users";
}

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

?>



<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/VICI/procesar_agregar_usuario_vici.php">
                    <div class="form-group">
                        <label for="rut">RUT:</label>
                        <input type="text" class="form-control" id="rut" name="rut" style="color: #000;" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" style="color: #000;" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="contrasena" name="contra" style="color: #000;"
                            required>
                    </div>

                    <div class="form-group">

                        <p class="card-description">Nivel:</p>
                        <select id="usu" name="usu" class="custom-select" required>
                            <option value="">Elige una opción</option>
                            <option value="Agente">Agente</option>
                            <option value="Supervisor">Supervisor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <p class="card-description">Grupo de usuario:</p>
                        <select id="grupo" name="grupo" class="custom-select" required>
                            <option value="">Elige una opción</option>
                            <?php
                            // Conectar a la base de datos (ya lo has hecho previamente)
                            
                            // Consulta específica para obtener los grupos desde la otra tabla
                            $queryGrupos = "SELECT user_group FROM vicidial_user_groups";
                            $resultGrupos = $conn->query($queryGrupos);

                            // Mostrar opciones en el combobox
                            while ($rowGrupo = $resultGrupos->fetch_assoc()) {
                                echo "<option value='" . $rowGrupo['user_group'] . "'>" . $rowGrupo['user_group'] . "</option>";
                            }
                            ?>

                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>

            </div>
        </div>
    </div>
</div>




<div class="card">
    <div class="card-body">
        <h4 class="card-title">Usuarios CRM</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr class="<?php echo $counter % 2 == 0 ? 'even' : 'odd'; ?>">
                                <th scope="col">#</th>
                                <th scope="col">RUT</th>
                                <th scope="col">Contraseña</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">nivel de usuario</th>
                                <th scope="col">grupo de usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1; // Inicializamos el contador
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                                    <th scope='row'>" . $counter . "</th>
                                                    <td>" . $row["user"] . "</td>
                                                    <td>" . $row["pass"] . "</td>
                                                    <td>" . $row["full_name"] . "</td>
                                                    <td>" . $row["user_level"] . "</td>
                                                    <td>" . $row["user_group"] . "</td>
                                                    
                                                  </tr>";
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>No hay usuarios en la base de datos</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn-save btn btn-primary btn-sm" data-toggle="modal" data-target="#agregarUsuarioModal"
        style="margin-left: 82%; width: 15%; height: 5%;margin-bottom: 10px">
        Agregar usuario
    </button>
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
<script src="../assets/js/shared/data-table.js"></script>