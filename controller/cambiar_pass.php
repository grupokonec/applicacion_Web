<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';


// Obtener datos del formulario de gestion_
$nombre_cliente = $_POST['usu_usu'];
$correo_cliente = $_POST['correo'];


if (empty($nombre_cliente) || empty($correo_cliente)) {
    
    echo "Usuario o correo están vacíos. Por favor, complete todos los campos.";
}

// Resto del código para insertar en la base de datos (si es necesario)
// ...

try {
    // Configuración del servidor SMTP
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.grupokonectados.cl';
    $mail->SMTPAuth = true;
    $mail->Username = 'vespucio.sur@grupokonectados.cl';
    $mail->Password = 'Enero2024';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Destinatario y remitente
    $mail->setFrom('soporte@grupokonectados.cl', 'Soporte');
    $mail->addAddress($correo_cliente);
    $mail->addAddress('soporte@grupokonectados.cl');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'CAMBIAR CUENTA';
    $mail->Body = 'Hola ' . $nombre_cliente . ', ingrese al
     siguiente link para poder cambiar su clave de seguridad.
     <br>
     <br>
     <a href="http://localhost/xampp/KON3CTADOS/KON3CTADOS/view/recuperar_cuenta.php">Cambiar Clave</a>
    '

    ;


    // Envío del correo
    $mail->send();
    echo 'El correo ha sido enviado correctamente.';
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
}

?>