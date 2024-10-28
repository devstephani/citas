<?php
    include_once './../../../config/config.php';
    include './conexion.php';

    // Incluir archivo de conexión a la base de datos

    // Obtener datos del formulario
    $nombreCompleto = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    //Encriptar contraseña
    $contrasena = hash('sha512', $contrasena);

    // Validar si el correo electrónico ya existe
    $verificar_Correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");
    $verificar_usiario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");

    if (mysqli_num_rows($verificar_Correo) > 0) {
        echo '<script>
                alert("Este correo ya está registrado, intente nuevamente");
                window.location = "' . RUTA_PRINCIPAL . '";
            </script>';
        exit(); // Detener la ejecución del script
    }

    if (mysqli_num_rows($verificar_usiario) > 0) {
        echo '<script>
                alert("Este usuario ya está registrado, intente nuevamente");
                window.location = "' . RUTA_PRINCIPAL . '";
            </script>';
        exit(); // Detener la ejecución del script
    }
    $query = mysqli_query($conexion, "SELECT * FROM `cargo` WHERE `descripcion` = 'cliente'");
    $cliente = mysqli_fetch_assoc($query);
    $cliente_id = $cliente['ID'];
    // Preparar la consulta SQL para insertar el usuario
    $consulta = "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena, roll)
                VALUES ('$nombreCompleto', '$correo', '$usuario', '$contrasena', '$cliente_id')";

    // Ejecutar la consulta SQL
    $ejecutar = mysqli_query($conexion, $consulta);

    // Verificar si la consulta se ejecutó correctamente
    if ($ejecutar) {
        echo '<script>
                alert("Usuario almacenado exitosamente");
                window.location = "'. RUTA_PRINCIPAL . 'login";
            </script>';
    } else {
        echo '<script>
                alert("Error al registrar el usuario. Intente nuevamente.");
                window.location = "'. RUTA_PRINCIPAL . '";
            </script>';
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

?>
