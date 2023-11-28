                 
                
                 
                 
                 <div class="alert alert-success" role="alert">
                    
                          Cuadratura de <strong>Globalvia cambiada</strong> 
                        </div>

                          <?php
                            // Conexión a la base de datos
                            $servername = "35.226.0.51";
                            $username = "root";
                            $password = "kon.dat00,55+";
                            $database = "bdcl1";

                            $conn = new mysqli($servername, $username, $password, $database);

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                           // Llamar al procedimiento almacenado
                            $query = "SELECT * FROM cuadratura_diaria";
                            $result = $conn->query($query);

                            // Verificar si la llamada al procedimiento fue exitosa
                            if (!$result) {
                                die("Error al llamar al procedimiento almacenado: " . $conn->error);
                            }

                            // Mostrar el resultado                         


                            // Cerrar la conexión a la base de datos
                          
                            ?>
                            <div id="js-grid-sortable" class="jsgrid" style="position: relative; height: 500px; width: 100%;">
                            <table class="table table-bordered  table-striped w-100 jsgrid-table">
                            <tr>
                                <th style="text-align: center">Tipo de Cobranza</th>
                                <th style="text-align: center">Clientes</th>
                                <th style="text-align: center">Documentos</th>
                                <th style="text-align: center">Total</th>
                            </tr>

                            <?php
                            // Mostrar resultados en HTML
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td style='text-align: center;'>" . $row['tipo_cobranza'] . "</td>";
                                echo "<td style='text-align: center;'>" . number_format($row['CLIENTES'], 0, '.', '.') . "</td>";
                                echo "<td style='text-align: center;'>" . number_format($row['DOCUMENTOS'], 0, '.', '.') . "</td>";
                                echo "<td style='text-align: center;'>" . number_format($row['MONTO'], 0, '.', '.') . "</td>";
                                echo "</tr>";
                            }
                            ?>

                        </table>
                    </div>

                        <?php
                        // Cerrar la conexión a la base de datos
                        $conn->close();
         ?>
