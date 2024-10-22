<link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/modelo.css">

<body>
    <div class="container"> 
            <h2>
                Ingrese el codigo que se le envio a su correo
            </h2>
        <form action="<?php echo RUTA_PRINCIPAL . 'assets/principal/php'; ?>/verificar.php" class="form" method="post">
            <div class="form__correo">
                <input required name="codigo" type="text" placeholder="Ingrese su codigo" class="correo">
                </div>
                <div class="form__button">
                    <a class="salir" href="<?php echo RUTA_PRINCIPAL?>">Salir</a>
                <!-- <a required  class="enviar" values="" href="inicio.php" >Enviar</a>  -->
                <button class="enviar" type="submit" value="Enviar">Enviar</button>
            </div>
        </form> 
    </div>   
</body>