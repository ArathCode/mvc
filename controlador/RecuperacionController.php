<?php
require_once "../modelos/ModeloRecuperacion.php";
require '../lib/PHPMailer-master/src/Exception.php';
require '../lib/PHPMailer-master/src/PHPMailer.php';
require '../lib/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['correo'])) {
        echo json_encode(["success" => false, "message" => "Correo no proporcionado."]);
        exit();
    }

    $correo = trim($_POST['correo']);
    $usuario = new Recuperacion();
    $datosUsuario = $usuario->obtenerUsuarioPorCorreo($correo);

    if (!$datosUsuario) {
        echo json_encode(["success" => false, "message" => "El correo no está registrado."]);
        exit();
    }

    $nom = $datosUsuario['Nombre'];
    $apellidoP = $datosUsuario['ApellidoP'];
    $apellidoM = $datosUsuario['ApellidoM'];

 
    $nuevaPass = bin2hex(random_bytes(4)); 
    $hashPass = password_hash($nuevaPass, PASSWORD_DEFAULT);

    // Actualizar la nueva contraseña en la BD
    if (!$usuario->actualizarContraseña($correo, $hashPass)) {
        echo json_encode(["success" => false, "message" => "Error al actualizar la contraseña."]);
        exit();
    }
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arathsaavedracabrera96@gmail.com';
        $mail->Password = 'cgjyqkeiatrpbxbr';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('arathsaavedracabrera96@gmail.com', 'Gestión de Dragon Gym');
        $mail->addAddress($correo, $nom);
        $mail->Subject = 'RECUPERACIÓN DE CONTRASEÑA';

        $mail->addEmbeddedImage('../asset/images/logo.jpg', 'DragonGymLogo');
        $mail->isHTML(true);
        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; color: black;'>
            <div style='text-align: center; padding: 20px;'>
                <h1 style='color: #8d2e27;'>Hola, $nom</h1>
                <p>Se ha generado una nueva contraseña temporal para tu cuenta:</p>
                <p style='font-size: 18px; font-weight: bold;'>$nuevaPass</p>
                <p>Por favor, inicia sesión y cambia tu contraseña lo antes posible.</p>
                <img src='cid:DragonGymLogo' alt='DragonGym' style='width:100px; height:auto;'>
            </div>
        </body>
        </html>";

        $mail->send();
        echo json_encode(["success" => true, "message" => "Correo enviado con éxito."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error al enviar el correo: {$mail->ErrorInfo}"]);
    }
}
?>
