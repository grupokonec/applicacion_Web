<?php
include("MyChat.php");
require __DIR__ . '/../vendor/autoload.php';

// Asegúrate de usar el espacio de nombres correcto para MyChat

$ip = "192.168.1.145"; // Cambia la dirección IP a la de tu servidor
//$ip = "172.31.87.8";
$port = 8000; // Cambia el puerto a tu preferencia

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyChat()
        )
    ),
    $port,
    $ip
);

echo "Servidor corriendo en el puerto \n";

$server->run();

?>
