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