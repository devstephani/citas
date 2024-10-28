<?php
    include_once './../../../config/config.php';
    include './conexion.php';

    session_start();
    $to = $_POST['correo'];

    $validar_email = mysqli_query($conexion, "SELECT correo FROM usuarios WHERE correo = '$to'");
    if (mysqli_num_rows($validar_email) > 0) {
        $_SESSION['correo'] = $to;
        EnviarCodigo($to);
    } else {
        echo 'Este correo no esta registrado';
    }

    function sendEmail($to, $subject, $message) {
        $headers = 'From: stephannyvilla89@gmail.com' . "\r\n" .
        'Reply-To: stephannyvilla89@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $email = @mail($to, $subject, $message, $headers);
        if ($email) {
            return true;
        } else {
            return false;
        }
    }

    function EnviarCodigo($to){
        $code = bin2hex(random_bytes(3));
        $_SESSION['code'] = $code;
        $_SESSION['exp_code'] = time() + 60 * 5;

        $subject = 'Codigo de recuperacion de contraseña';
        $message = 'Hola, este es tu codigo de recuperacion de contraseña: ' . $code;

        if (sendEmail($to, $subject, $message)) {
            header('Location: '. RUTA_PRINCIPAL . 'codigo');
        } else {
            echo 'Hubo un error al enviar el correo';
        }
    }

?>