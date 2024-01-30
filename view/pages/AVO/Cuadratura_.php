<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Cuadratura</h4>
        <div class="row grid-margin">
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              Cuadratura de seguimiento <strong>AVO</strong> </div>

            <?php
            // Conexión a la base de datos
            $servername = "35.226.0.51";
            $username = "root";
            $password = "kon.dat00,55+";
            $database = "bdcl22";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
              die("Conexión fallida: " . $conn->connect_error);
            }

            // Llamar al procedimiento almacenado
            $query = "SELECT * FROM vw_cuadratura_seguimiento";
            $result = $conn->query($query);

            // Verificar si la llamada al procedimiento fue exitosa
            if (!$result) {
              die("Error al llamar al procedimiento almacenado: " . $conn->error);
            }

            // Mostrar el resultado                         
            

            // Cerrar la conexión a la base de datos
            
            ?>





            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align: center; font-size:80%;">Rut</th>
                  <th style="text-align: center; font-size:80%;">Boletas</th>
                  <th style="text-align: center; font-size:80%;">Monto</th>

                </tr>
              </thead>

              <?php
              // Mostrar resultados en HTML
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='text-align: center; font-size:80%;'>" . number_format($row['Rut'], 0, '.', '.') . "</td>";
                echo "<td style='text-align: center; font-size:80%;'>" . number_format($row['Boletas'], 0, '.', '.') . "</td>";
                echo "<td style='text-align: center; font-size:80%;'>" . number_format($row['Monto'], 0, '.', '.') . "</td>";
                echo "</tr>";
              }
              ?>

            </table>



            <?php
            // Cerrar la conexión a la base de datos
            $conn->close();
            ?>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="table-responsive">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>