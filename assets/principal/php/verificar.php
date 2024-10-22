<?php
    include_once './../../../config/config.php';
    include './conexion.php';

    session_start();
    $code = $_POST['codigo'];

    if ($code === $_SESSION['code'] && time() < $_SESSION['exp_code']) {
        unset($_SESSION['code']);
        unset($_SESSION['exp_code']);
        header('Location: '. RUTA_PRINCIPAL . 'nueva_clave');
    } else {
        if (time() > $_SESSION['exp_code']) {
            unset($_SESSION['code']);
            unset($_SESSION['exp_code']);
            
            echo '<script>
            alert("Codigo expirado.");
            window.location = "'. RUTA_PRINCIPAL . 'codigo";
        </script>
          '; // ACA DEBERIA REDIRECCIONAR A LA PAGINA DE RECUPERAR CONTRASEÑA
            // header('Location: ../nueva_clave.php');
        }

        if ($code !== $_SESSION['code']) {
            echo '<script>
            alert("Codigo incorrecto.");
            window.location = "'. RUTA_PRINCIPAL . 'codigo";
        </script>
          ';
        }
    }

?>