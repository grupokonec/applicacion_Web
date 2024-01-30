<?php

include("../../config/conexionReporte.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/Exception.php';
require '../../phpmailer/PHPMailer.php';
require '../../phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["name"];
    $correo = $_POST["email"];
    $titulo = $_POST["titulo"];
    $glosa = $_POST["asunto"];
    $tipo = $_POST["tipo"];
    $urgencia = $_POST["urgencia"];
    $rut = $_POST["rut"];














    $id = uniqid();

    date_default_timezone_set('America/Santiago');
    $fecha = date("Y-m-d H:i:s"); // Formato "YYYY-MM-DD HH:MM:SS"

    try {
        // Realizar la conexión a la base de datos
        $connecion = new ConnectionOne("konexnet");

        // Preparar la consulta
        $query = "INSERT INTO ticket (id, nombre, texto, fecha, id_estado, correo, tipo, urgencia, idUsuario, titulo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$id, $nombre, $glosa, $fecha, 1, $correo, $tipo, $urgencia, $rut, $titulo];

        // Ejecutar la consulta
        $stmt = $connecion->queryExe($query, $params);


        $response = ["success" => "success"];


    } catch (Exception $e) {
        // Capturar cualquier excepción y devolver un mensaje de error
        $response = ["error" => $e->getMessage()];
    }

    // Devolver la respuesta en formato JSON
    echo json_encode($response);
}
?>