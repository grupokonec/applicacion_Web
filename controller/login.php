<?php


include("../config/conexionBD.php");

session_start();

$usu_usuario = isset($_REQUEST['usu_usuario']) ? $_REQUEST['usu_usuario'] : '';
$usu_clave = isset($_REQUEST['usu_clave']) ? $_REQUEST['usu_clave'] : '';

// Utiliza consultas preparadas para evitar inyecciones SQL
$sql = "SELECT
    usuarios.ids,
    Empresas.Emp,
    usuarios.Nombre
FROM usuarios
INNER JOIN Empresas
    ON usuarios.ids = Empresas.cod
WHERE Nombre = :usu_usuario AND contraseña = :usu_clave";


$query = $con->prepare($sql);

// Bind de los parámetros
$query->bindParam(':usu_usuario', $usu_usuario, PDO::PARAM_STR);
$query->bindParam(':usu_clave', $usu_clave, PDO::PARAM_STR);

// Ejecutar la consulta
$query->execute();

// Obtener resultados
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
     // Inicializa un arreglo para almacenar múltiples valores
     $empArray = array();
    foreach ($results as $result) {
        $_SESSION['name'] = $result->Nombre;
        $_SESSION['usu_id'] = $result->ids;	
        // Almacena los valores de 'Emp' en el arreglo
        $empArray[] = $result->Emp;     
    }
     // Almacena el arreglo en la sesión
     $_SESSION['prove'] = $empArray;

    header("Location: ../view/dashboard.php");
        exit();
    
} else {
    // Evita el uso de alertas en scripts y utiliza mensajes de error adecuados.
    $_SESSION['error_message'] = 'No se pudo iniciar sesión. Usuario y/o contraseña incorrectos.';
    header("Location: ../index.php");
    exit();
}
