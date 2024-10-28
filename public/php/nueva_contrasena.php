<?php
    include_once './../../../config/config.php';
    include './conexion.php';

    session_start();

    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha512', $contrasena);
    $email = $_SESSION['correo'];

    $actualizar_contrasena = mysqli_query($conexion, "UPDATE usuarios SET contrasena = '$contrasena' WHERE correo = '$email'");
    if ($actualizar_contrasena) {
        header('Location: '. RUTA_PRINCIPAL. 'login');
    } else {
        echo 'Hubo un error al actualizar la contraseña';
    }
?>
