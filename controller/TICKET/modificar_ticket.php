<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/Exception.php';
require '../../phpmailer/PHPMailer.php';
require '../../phpmailer/SMTP.php';

$servername = "35.226.0.51";
$username = "root";
$password = "kon.dat00,55+";
$database = "konexnet";




// Verificar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar la existencia de los datos necesarios
    if (isset($_POST['id_ticket'], $_POST['mod_tik_estado'], $_POST["tercerComboBox"])) {
        $id_ticket = $_POST['id_ticket'];
        // Obtener la fecha actual
        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");  // Formato "YYYY-MM-DD HH:MM:SS"

        $correo_cliente = $_POST['correo'];
        $correo_People = $_POST['tercerComboBox'];

        if (isset($_POST['mod_tik_estado'])) {
            $id_estado = $_POST['mod_tik_estado'];
        } elseif (isset($_POST['act_estado'])) {
            $id_estado = $_POST['act_estado'];
        } else {
            echo "Error: No se proporcionó ni 'mod_tik_estado' ni 'act_estado'.";
            exit;
        }


        // Crear una conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión a la base de datos
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar la consulta para actualizar el estado del ticket
        $updateQuery = "UPDATE ticket SET estado = ?, fecha_estado = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($updateQuery);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmtUpdate === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Vincular los parámetros y ejecutar la consulta
        $stmtUpdate->bind_param("sss", $id_estado, $fecha, $id_ticket);
        $stmtUpdate->execute();

        // Verificar si la ejecución de la consulta fue exitosa
        if ($stmtUpdate->affected_rows > 0) {
            // Configurar PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.grupokonectados.cl';
            $mail->SMTPAuth = true;
            $mail->Username = 'prueba@grupokonectados.cl';
            $mail->Password = 'Diciembre2023';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // o 'ssl' dependiendo de tu configuración
            $mail->Port = 465; // o el puerto que estés utilizando

            $mail->setFrom('prueba@grupokonectados.cl', 'Soporte Kon3ctados');
            $mail->Subject = 'Cambio de estado de ticket';

            // Enviar correo al cliente
            //soporte solo a los personas 
            $mail->addAddress($correo_cliente);
            $mail->Subject = 'Cambio de estado de ticket';
            $mail->Body = 'El ticket con ID ' . $id_ticket . ' ha cambiado de estado. <br>
            Favor de revisar en "http://192.168.1.147/KON3CTADOS/index.php"';
            $mail->send();


            
            // Limpiar destinatarios y enviar correo a People
            $mail->clearAddresses();
            $mail->addAddress($correo_People);
            $mail->Body = 'Se le asignó el siguiente ticket ' . $id_ticket;
            $mail->send();
            // Limpiar destinatarios y enviar correo a People




            //derivado 
            $mail->clearAddresses();
            $mail->addAddress($correo_People);
            $mail->Body = 'Se le asignó el siguiente ticket ' . $id_ticket;
            $mail->send();




            header("Location: ../../view/dashboard.php");
            exit; // Terminar el script después de la redirección
        } else {
            $errorMessage = "Error al modificar el ticket: No se realizaron cambios";
            echo $errorMessage;
        }

        // Cerrar la declaración preparada
        $stmtUpdate->close();

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        echo "Error: Datos insuficientes para procesar la solicitud.";
    }
} else {
    echo "Error: La solicitud no es de tipo POST.";
}
?>