<?php

include("../../config/conexionBD.php");



// Verifica si se ha enviado un formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Itera sobre los valores de $_POST para encontrar los valores de los checkboxes

    if (isset($_POST["habilitado"])) {
        actualizarEstado(1, $conn);
    }

    if (isset($_POST["deshabilitado"])) {
        actualizarEstado(0, $conn );
    }
}

function actualizarEstado($nuevoEstado, $conn)
{
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'checkbox_') !== false) {
            $formId = substr($key, strpos($key, '_') + 1);
            $checkboxValues = $_POST[$key];
    
            foreach ($checkboxValues as $empresaId) {
                // Verificar si ya existe la combinación
                $existsQuery = "SELECT COUNT(*) FROM Asignacion WHERE Usuarios_idUsuarios = $formId AND Empresa_idEmpresa = $empresaId";
                $existsResult = $conn->query($existsQuery);
    
                if (!$existsResult) {
                    error_log("Error al verificar la existencia del registro: " . $conn->error);
                    header("Location: ../../view/dashboard.php");
                    exit();
                }
    
                $rowCount = $existsResult->fetchColumn();
    
                // Realizar un único INSERT o UPDATE condicional
                if ($rowCount > 0) {
                    $query = "UPDATE Asignacion SET estado = $nuevoEstado WHERE Usuarios_idUsuarios = $formId AND Empresa_idEmpresa = $empresaId";
                } else {
                    $query = "INSERT INTO Asignacion (Usuarios_idUsuarios, Empresa_idEmpresa, estado) VALUES ($formId, $empresaId, $nuevoEstado)";
                }
    
                $result = $conn->query($query);
    
                
                if (!$result) {
                    error_log("Error al ejecutar la consulta SQL: " . $conn->error);
                    header("Location: ../../view/error.php");
                    exit();
                }
            }
        }

        // Redirigir después de la ejecución
header("Location: ../../view/dashboard.php");
exit();
    }
}


