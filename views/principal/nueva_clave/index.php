<link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/modelo.css">

<body>
     <div class="container"> 
        <h2>
            Ingresa tu nueva contraseña
        </h2>
        <form action="<?php echo RUTA_PRINCIPAL . 'assets/principal/php'; ?>/nueva_contrasena.php" class="form" method="post">
            <div class="form__correo">
                <input required name="contrasena" type="text" placeholder="Ingrese su contraseña" class="correo">
                </div>
                <div class="form__button">
                    <a class="salir" href="<?php echo RUTA_PRINCIPAL; ?>recuperar_contra">Salir</a>
                <!-- <a required  class="enviar" values="" href="inicio.php" >Enviar</a>  -->
                <button class="enviar" type="submit" value="Enviar">Enviar</button>
            </div>
        </form> 
    </div>   
</body>