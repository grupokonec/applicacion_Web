
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
// Realiza la consulta para obtener los datos de las empresas
$query2 = "SELECT nombreEmpresas, idEmpresas FROM Empresas e";
$result2 = $conn->query($query2);

// Verifica si la llamada a la consulta fue exitosa
if (!$result2) {
    die("Error al ejecutar la consulta: " . $conn->error);
}

// Almacena los datos de las empresas en un array
$empresas = [];
while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
    $empresas[] = $row2;
}
?>

<!-- ... Tu código HTML ... -->

<?php
// Realiza la consulta para obtener los datos de los usuarios
$query = "SELECT * FROM Usuarios u";
$result = $conn->query($query);

// Verifica si la llamada a la consulta fue exitosa
if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}
?>

<div class="row">
    <div class="col-12">
        <div id="js-grid-static" class="jsgrid" style="position: relative; height: 500px; width: 100%;">
            <div class="jsgrid-grid-body" style="height: 402.125px;">
                <table class="jsgrid-table">
                    <thead>
                        <tr>
                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 150px;">Rut</th>
                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 150px;">Nombre</th>

                            <?php
                            // Itera sobre los datos de las empresas para crear las columnas
                            foreach ($empresas as $empresa) {
                                ?>
                                <th class="jsgrid-header-cell jsgrid-header-sortable" style="font-size:80%; width: 150px; max-width: 150px;"  class='resizable-column'>
                                    <?php echo $empresa['nombreEmpresas']; ?>
                                </th>
                                <?php
                            }
                            ?>

                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 150px;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Itera sobre los datos de los usuarios para llenar la tabla
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $formId = $row['Rut'];
                            ?>
                            <tr class='jsgrid-row'>
                                <td class='jsgrid-cell'>
                                    <?php echo $row['Rut']; ?>
                                </td>
                                <td class='jsgrid-cell jsgrid-align-right' style='width: 150px;'>
                                    <?php echo $row['Nombre']; ?>
                                </td>

                                <?php
                                // Itera sobre los datos de las empresas para crear las celdas de los checkboxes
                                foreach ($empresas as $empresa) {
                                    ?>
                                    <td class='jsgrid-cell'>
                                        <div class='form-check mt-0'>
                                            <label class='form-check-label'>
                                                <input type='checkbox' value="<?php echo $empresa['idEmpresas']; ?>"
                                                    class='form-check-input' form="checkbox_<?php echo $formId; ?>"
                                                    name='checkbox_<?php echo $formId; ?>[]'>
                                                <i class='input-helper'></i>
                                            </label>
                                        </div>
                                    </td>
                                    <?php
                                }
                                ?>

                                <td class='jsgrid-cell' style='width: 100px;'>
                                    <div class='form-check mt-0'>
                                        <form action="../controller/USUARIOS/controllerAcciones.php" method="POST"
                                            id="checkbox_<?php echo $formId; ?>">
                                            <button type='submit' class='btn btn-success' name="habilitado"
                                                style='border-radius: 50%; width: 30px; height: 30px; margin-right: 10px; display: flex; justify-content: center; align-items: center;'>
                                            </button>
                                            <button type='submit' class='btn btn-danger' name="deshabilitado"
                                                style='border-radius: 50%; width: 30px; height: 30px;'>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
