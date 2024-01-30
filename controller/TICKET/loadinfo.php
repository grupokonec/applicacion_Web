<?php
include("../../config/conexionReporte.php");


$conexion = new ConnectionOne("konexnet");


$userquery = "SELECT * FROM Usuarios;";
$Groupquery = "SELECT * FROM Grupos";
$Ticketquery = "SELECT * FROM ticket INNER JOIN Estados e ON ticket.id_estado = e.id_estado WHERE DATE(fecha) = CURDATE() ORDER BY fecha DESC";

$dataUser = $conexion->queryExe($userquery);
$dataGroup = $conexion->queryExe($Groupquery);
$dataticket = $conexion->queryExe($Ticketquery);

$resultados=[
    "usuarios"=> $dataUser,
    "group"=> $dataGroup,
    "ticket" => $dataticket
];

echo json_encode($resultados);






?>