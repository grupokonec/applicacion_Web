<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/Exception.php';
require '../../phpmailer/PHPMailer.php';
require '../../phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enviarCorreo'])) {
    // Obtener datos del formulario de gestion_
    $nombre_cliente = $_POST['nombre'];
    $correo_cliente = $_POST['correo'];

    // Resto del código para insertar en la base de datos (si es necesario)
    // ...

    try {
        // Configuración del servidor SMTP
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'mail.grupokonectados.cl';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vespucio.sur@grupokonectados.cl';
        $mail->Password   = 'Enero2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Destinatario y remitente
        $mail->setFrom('vespucio.sur@grupokonectados.cl', 'Vespucio Sur');
        $mail->addAddress($correo_cliente);
        $mail->addAddress('vespucio.sur@grupokonectados.cl');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'PASO A PASO PARA TOMAR UN CONVENIO EN VESPUCIO SUR';
        $mail->Body ='<!-- HTTP 1.1 --><meta http-equiv="Cache-Control" content="no-store" /><!-- HTTP 1.0 --><meta http-equiv="Pragma" content="no-cache" /><!-- Prevents caching at the Proxy Server --><meta http-equiv="Expires" content="0" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="generator" content="AppFuse 2.0" /><meta http-equiv="Description" content="itd, desarrollo de software, mailings masivos, sms masivos, gestion de datos, hosting" /><meta http-equiv="Keywords" content="informatica, innovacion, tecnologia, desarrollo, software, mailing, sms, web, email, marketing" /><meta http-equiv="abstract" content="ITD es una empresa dedicada el desarrollo de soluciones informaticas a la medida. ITD desarrollo un software de gestion de bases de datos y envios masivos de mailings y SMS orientada al marketing" />
        <div class="powerwidget dark-blue" data-widget-editbutton="false" data-widget-fullscreenbutton="false" role="widget">
        <div class="maincontent" style="padding: 20px;">
        <div style="text-align: center; color: #0f3866;">
        <table border="0" width="800" align="center" style="background-color: #FFFFFF">
        <tbody>
        <tr>
        <td align="center"><img src="https://assests-emails.s3.amazonaws.com/vsur/1.png" alt=""  width="800"  /></td>
        </tr>
        <tr>
        <td align="center"><img src="https://assests-emails.s3.amazonaws.com/vsur/2.png" alt=""width="800"  /></td>
        </tr>
        <tr>
        <td align="center"><img src="https://assests-emails.s3.amazonaws.com/vsur/3.png" alt="" width="800" /></td>
        </tr>
        <tr>
        <td align="center"><img src="https://assests-emails.s3.amazonaws.com/vsur/4.png" alt="" width="800" /></td>
        </tr>
        </tbody>
        </table>
        <table border="0" width="620" align="center" style="background-color: #FFFFFF">
        <tbody>
        <tr>
        <td>
        <p>&nbsp;</p>
        <p style="text-align: center;"><span style="font-size: 12pt; font-family: calibri;"><strong>Si tienes dudas para la gestión en tu portal Web, favor llamamos al 56226566473.</strong> </span></p>
        </td>
        </tr>
        <tr>
        <td>
        <p>&nbsp;</p>
        <p style="text-align: center;"><span style="font-size: 12pt; font-family: calibri;"><strong>TIPS PARA EVITAR ESTAFAS.</strong> </span></p>
        </td>
        </tr>                 
        <tr>
        <td>
        
        <p style="text-align: justify;"><span style="font-size: 9pt; font-family: calibri;"><strong>- Nunca, jamás, te llamaremos para pedir tus claves de acceso a tu portal WEB, ni las pediremos por e-mail ni por SMS.</strong> </span></p>
        </td>
        </tr>
        <tr>
        <td>                                   
        <p style="text-align: justify;"><span style="font-size: 9pt; font-family: calibri;"><strong>- Nunca, jamás, incluiremos links en nuestros correos electrónicos ni en nuestros SMS.</strong> </span></p>
        </td>
        </tr>
        <tr>
        <td>                              
        <p style="text-align: justify;"><span style="font-size: 9pt; font-family: calibri;"><strong>- Nunca, jamás, descargues archivos adjuntos de remitentes desconocidos.</strong> </span></p>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        </div>';

        // Envío del correo
        $mail->send();
        echo 'El correo ha sido enviado correctamente.';
        header("Location: ../../view/dashboard.php");
    } catch (Exception $e) {
        echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
} else {
    // Redirigir en caso de acceso directo al script sin enviar datos del formulario
    header("Location: ../../view/dashboard.php");
    exit();
}   
?>
