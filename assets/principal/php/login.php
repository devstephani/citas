<?php
    include_once './../../../config/config.php';
    include './conexion.php';
    session_start();

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha512', $contrasena);

    $validar_login = mysqli_query($conexion, "SELECT u.*, c.* FROM usuarios as u INNER JOIN cargo as c ON u.roll = c.ID
      WHERE u.correo = '$correo' AND u.contrasena = '$contrasena'");
      
    $usuario = mysqli_fetch_assoc($validar_login);

    if (isset($usuario)) {
        
      $_SESSION['usuario'] = $usuario['usuario'];
      $_SESSION['cargo'] = $usuario['descripcion'];
      $_SESSION['roll'] = $usuario['roll'];
      

    if ($usuario['roll'] == 1) {
        header("location: ". RUTA_PRINCIPAL . "inicio_admin");
        exit(); // Detener la ejecución
      } else {
        header(header: "location: ". RUTA_PRINCIPAL. "servicios");
        exit(); // Detener la ejecución
      }

    } else { 
        echo '<script>alert("Usuario o contraseña incorrectos. Por favor verifique sus datos."); 
        window.location = "' . RUTA_PRINCIPAL . 'login";
        </script>';
    exit(); // Detener la ejecución del script
    }
?>