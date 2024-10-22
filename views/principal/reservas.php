<?php include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php'; ?>

<section class="news-area ptb-100">
        <div class="container">
            <div class="section-title">
                <span><?php echo $data['title']; ?></span>
                <h2><?php echo $data['subtitle']; ?> </h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="alert alert-<?php echo $data['tipo']; ?> alert-dismissible fade show"
                        role="alert"
                    >
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                        ></button>
                    
                        <strong>Respuesta!</strong><?php echo $data['mensaje']; ?>
                    </div>
                    
                  <input id="f_reserva" type="hidden" value="<?php echo $data['disponible']['f_reserva'] ;?>">
                  <input id="hora" type="hidden" value="<?php echo $data['disponible']['hora'] ; ?>">
                  <input id="servicio" type="hidden" value="<?php echo $data['disponible']['servicio'] ; ?>">
                <div id='calendar'></div>
                </div>
            </div>
        </div>
    </section>
<?php include_once 'views/template/footer-principal.php'; ?>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/reservas.js'; ?>"></script>

</body>

</html> 