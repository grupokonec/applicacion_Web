<?php
include("../../../config/cnn.php");

$username = "root";
$database = "report00";

// Crear una instancia de la clase ConexionBD
$conexion = new ConexionBD($username, $database);

// Establecer la conexión
$conn = $conexion->conectar();


// Verificar la conexión
function consultarUsuarios($conn)
{
  // Modificar la consulta SQL según la presencia de RUT en la URL
  if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];
    $query = "SELECT * FROM users WHERE id = '$rut'";
  } else {
    $query = "SELECT * FROM users";
  }

  // Ejecutar la consulta y obtener el resultado
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verificar si se encontró el usuario
  if ($result->num_rows > 0) {
    return $result;
  } else {
    // Manejar el caso en que no se encuentre el usuario
    // Puedes redirigir a una página de error o realizar alguna otra acción.
    die("Usuario no encontrado");
  }
}

// Consultar usuarios
$result = consultarUsuarios($conn);


// Cerrar la conexión cuando ya no se necesite
$conexion->cerrarConexion();
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
        <form method="post" action='../controller/CRM/procesar_agregar_usuario.php'>
          <div class="form-group">
            <label for="idempresa">ID Empresa:</label>
            <input type="text" class="form-control" id="idempresa" name="idempresa" value="KON3CTADOS"
              style="color: #000;" readonly>
          </div>
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
            <input type="password" class="form-control" id="contrasena" name="contra" style="color: #000;" required>
          </div>

          <div class="form-group" hidden>
            <label for="nivel">Nivel:</label>
            <input type="text" class="form-control" id="nivel" name="nivel" value="1" style="color: #000;" readonly>
          </div>

          <div class="form-group" hidden>
            <label for="activo">Activo/Desactivo:</label>
            <input type="text" class="form-control" id="activo" name="activo" value="1" style="color: #000;" readonly>
          </div>

          <div class="form-group" hiddens>
            <label for="fecha_ing">Fecha de Ingreso:</label>
            <input type="text" class="form-control" id="fecha_ing" name="fecha_ing" style="color: #000;" readonly>
          </div>

          <button type="submit" class="btn btn-primary">Agregar Usuario</button>
        </form>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modcrmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action='../controller/CRM/modificar_crm.php'>       
            <div class="form-group" >
                <label>RUT</label>
                <input type="text" id="rut0" name="rut0" value="<?php echo $row["id"] ?>">
            </div>    
            <div class="form-group" >
                <label>Nombre:</label>
                <input type="text" id="nombre0" name="nombre0" value="<?php echo $row["name"] ?>">
            </div>
            
            <div class="form-group" >
                <label>Contraseña:</label>
                <input type="text" id="contra" name="contra" value="<?php echo $row["password"] ?>">
            </div>



        <input type="hidden" id="id_mod" name="id_mod">


                    <button type="submit" class="btn btn-primary">Modificar Ticket</button>
                </form>
            </div>
        </div>
    </div>
</div>




<div clase="card">
  <div>
    <div class="row">
      <div class="col-12 col-md-6"> <!-- Utiliza la mitad del ancho en dispositivos medianos y grandes -->
        <button type="button" class="btn-save btn btn-primary btn-sm" data-toggle="modal"
          data-target="#agregarUsuarioModal">
          Agregar usuario
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <h4 class="card-title">Usuarios CRM</h4>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr class="<?php echo $counter % 2 == 0 ? 'even' : 'odd'; ?>">
                <th scope="col">#</th>
                <th scope="col">ID empresa</th>
                <th scope="col">RUT</th>
                <th scope="col">Nombre</th>
                <th scope="col">Contraseña</th>
                <th scope="col">Activo/desactivo</th>
                <th scope="col">fecha de ingreso</th>
                <th scope="col"> </th>
              </tr>
            </thead>
            <tbody>
            <?php
$counter = 1; // Inicializamos el contador

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <th scope='row'>" . $counter . "</th>
                <td>" . $row["idempresa"] . "</td>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["password"] . "</td>
                <td>" . $row["active"] . "</td>
                <td>" . $row["fecha_ing"] . "</td>
                <td>
                    <form method='POST' action='../controller/CRM/activarusu.php'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <button type='submit' class='btn btn-primary'>Activar/Desactivar</button>
                    </form>
                    <form method='POST' action='modificarusu.php'>
                        <input type='hidden' name='us' value='" . $row["id"] . "'>
                        <button type='button' class='btn-save btn btn-danger btn-sm' data-toggle='modal' data-target='#modcrmModal' 
                            data-modid='" . $row["id"] . "' 
                            data-modname='" . $row["name"] . "' 
                            data-modcontra='" . $row["password"] . "' 
                            style='margin-top: 3px;'>
                            <i class='fa fa-pencil'></i>
                        </button>
                    </form>
                </td>
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

<script>
    // Script para establecer el valor de los campos del modal al abrirlo
    $('#modcrmModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var userId = button.data('modid');
        var userName = button.data('modname');
        var userContra = button.data('modcontra');

        // Establecer los valores de los campos del modal con los datos del usuario
        $('#id_mod').val(userId);
        $('#rut0').val(userId).prop('readonly', true);
        $('#nombre0').val(userName);
        $('#contra').val(userContra);
    });
</script>