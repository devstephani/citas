<link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/modelo.css">

<body>

 <h1>RECUPERAR CONTRASEÑA</h1>
     <div class="container"> 
        <h2>Ingrese su correo con el que se ha registrado</h2>
        <form action="<?php echo RUTA_PRINCIPAL . 'assets/principal/php'; ?>/send_email.php" class="form" method="post">
            <div class="form__correo">
                <input required name="correo" type="email" placeholder="Ingrese su correo" class="correo">
                </div>
                <div class="form__button">
                    <a class="salir" href="<?php echo RUTA_PRINCIPAL; ?>">Salir</a>
                <!-- <a required  class="enviar" values="" href="codigo.php" >Enviar</a>  -->
                <button class="enviar" type="submit" value="Enviar">Enviar</button>
            </div>
        </form> 
    </div>   
</body>