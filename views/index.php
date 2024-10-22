<?php 
 session_start();

 if(!isset($_SESSION['usuario'])){

    include_once 'views/template/header-index.php';
    
 }else {
    include_once 'views/template/header-principal.php';
    
 }



 ?>

<!-- Start Ecorik Slider Area -->
<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <?php foreach ($data['sliders'] as $slider) { ?>
        <div class="eorik-slider-item" style="background-image: url(<?php echo RUTA_PRINCIPAL . 'assets/img/sliders/' . $slider['foto']; ?>);">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="eorik-slider-text overflow-hidden one eorik-slider-text-one">
                            <h1><?php echo $slider['titulo'] ;?></h1>
                            <span><?php echo $slider['subtitulo'] ;?></span>
                            <div class="slider-btn">
                                <a class="default-btn" href="<?php echo $slider['url'] ;?>">
                                    Mas informacion
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="social-link">
        <ul>
            <li>
                <a href="#">
                    <i class="bx bxl-instagram"></i>
                </a>
            </li>
        </ul>
    </div>
</section>
<!-- End Ecorik Slider Area -->

<!-- Start Check Area -->
<div class="check-area mb-minus-70">
    <div class="container">
        <form class="check-form" id="formulario" action="<?php echo RUTA_PRINCIPAL . 'reserva/verify'; ?>">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de Llegada</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-1">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control" id="f_reserva" name="f_reserva"  value="<?php echo date('Y-M-D'); ?>">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                

                 <div class="col-lg-3">
                <div class="check-content">
                <div class="form-group">
                    <label for="hora" class="form-label">Hora disponibles</label>
                    <select name="hora" id="hora" class="select-auto" id="hora" style="width: 100%" value = "<?php echo date('HH:MM:SS'); ?>">
                        <option value="">Seleccionar</option>
                        <?php foreach ($data['hora'] as $hora) { ?>
                        <option value="<?php echo $hora['hora_entrada'] ?>"><?php echo $hora['hora_entrada'] ?></option>
                        <?php }; ?>
                    </select>
                  </div>
                </div>
                </div>
                <div class="col-lg-3">
                <div class="check-content">
                <div class="form-group">
                    <label for="servicio" class="form-label">Servicios</label>
                    <select name="servicio" class="select-auto" id="servicio" style="width: 100%">
                        <option value="">Seleccionar</option>
                        <?php foreach ($data['servicios'] as $servicio) { ?>
                        <option value="<?Php echo $servicio['id'] ?>"><?Php echo $servicio['estilo'] ?></option>
                        <?php }; ?>
                    </select>
                  </div>
                </div>
                </div>
                <div class="col-lg-3">
                    <div class="check-btn check-content mb-0">
                        <button class="default-btn" type="submit">
                            Comprobar
                             Disponibilidad
                            <i class="flaticon-right"></i>
                        </button>
                        <a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Check Section -->

<!-- Start Explore Area -->
<section class="explore-area pt-170 pb-100">
    <div class="container">
        <div class="section-title">
            <span>Salon de Belleza</span>
            <h2>Browslashes_stefy</h2>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="explore-img">
                </div>
            </div>
            <div class="col-lg-6" >
                <div class="explore-content ml-30"> 
                    <p style="text-align: center;">RESENA</p>
                    <p>Nace el salón de belleza BROWSLASHES_STEFY en el año 2022, encargado por Damaris Pérez, al principio solo se contaba con una silla de sala, y pocos implementos para trabajar, ya que se trabajaba en un espacio de la sala, también el nivel de clientes era poco, por el hecho de que recién se empezaba el emprendimiento.</p>
                    <a href="about.html" class="default-btn">
                        explore More
                        <i class="flaticon-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Explore Area -->

<section class="news-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>Presentacion</span>
            <h2>Empleado</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                        <div style="display: flex; justify-content: center;">
  <img style="width: 50%; border-radius: 10px;" src="<?php echo RUTA_PRINCIPAL . 'assets/img/presentacion'; ?>/stefy.jpg" alt="Image">
</div>

                        </a>
                    </div>
                    <div class="news-content-wrap">
                        <a href="news-details.html">
                            <h3>stephany Villasmil</h3>
                        </a>
                        <p>Lashista, Trabaja en la area de cejas,pestañas y epilacion coorporal.</p>
                        <a class="read-more" href="news-details.html">
                           Lashista
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                        <div style="display: flex; justify-content: center; border-radius: 10px;">
  <img style="width: 50%; border-radius: 10px;" src="<?php echo RUTA_PRINCIPAL . 'assets/img/presentacion'; ?>/jose.jpg" alt="Image">
</div>
                    </div>
                    <div class="news-content-wrap">
                        <a href="news-details.html">
                            <h3>Jose David</h3>
                        </a>
                        <p>Maquillador profesional y creador de contenido en el area de la Belleza de la mujer sobre (Makeup).</p>
                        <a class="read-more" href="news-details.html">
                        Makeup Artist
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/news/1.jpg" alt="Image">
                        </a>
                    </div>
                    <div class="news-content-wrap">
                        <a href="news-details.html">
                            <h3>Nombre</h3>
                        </a>
                        <p>Peinadora para toda clase de eventos tanto para niñas y adultos.</p>
                        <a class="read-more" href="news-details.html">
                           oficio
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Start Our Rooms Area -->
<section class="our-rooms-area pt-60 pb-100">
    <div class="container">
        <div class="section-title">
            <span>SERVICIOS</span>
            <h2>Paquetes</h2>
        </div>
        <div class="tab industries-list-tab">
            <div class="row">
                <div class="col-lg-4">
                    <ul class="tabs">
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-1.jpg" alt="Image">
                            <div class="room-content">
                                <h3>Double Room</h3>
                                <span>From $75.9/night</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-2.jpg" alt="Image">
                            <div class="room-content">
                                <h3>Luxury Room</h3>
                                <span>From $50.9/night</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-3.jpg" alt="Image">
                            <div class="room-content">
                                <h3>Best Room</h3>
                                <span>From $70.9/night</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-4.jpg" alt="Image">
                            <div class="room-content">
                                <h3>Classic Room</h3>
                                <span>From $95.9/night</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-5.jpg" alt="Image">
                            <div class="room-content">
                                <h3>Budget Room</h3>
                                <span>From $95.9/night</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="tab_content">
                        <div class="tabs_item">
                            <div class="our-rooms-single-img room-bg-1">
                            </div>
                            <span class="preview-item">The Preview Of Double Room</span>
                        </div>
                        <div class="tabs_item">
                            <div class="our-rooms-single-img room-bg-2">
                            </div>
                            <span class="preview-item">The Preview Of Luxury Room</span>
                        </div>
                        <div class="tabs_item">
                            <div class="our-rooms-single-img room-bg-3">
                            </div>
                            <span class="preview-item">The Preview Of Best Room</span>
                        </div>
                        <div class="tabs_item">
                            <div class="our-rooms-single-img room-bg-4">
                            </div>
                            <span class="preview-item">The Preview Of Classic Room</span>
                        </div>
                        <div class="tabs_item">
                            <div class="our-rooms-single-img room-bg-5">
                            </div>
                            <span class="preview-item">The Preview Of Budget Room</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Our Rooms Area -->

<!-- End News Area -->
<section class="news-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>BELLEZA</span>
            <h2>Makeup</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/news/1.jpg" alt="Image">
                        </a>
                        <div class="dates">
                            <span>HOTEL</span>
                        </div>
                    </div>
                    <div class="news-content-wrap">
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="flaticon-user"></i>
                                    Admin
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="flaticon-conversation"></i>
                                    Comment
                                </a>
                            </li>
                        </ul>
                        <a href="news-details.html">
                            <h3>Celebrating Decade Years Of Hotel In 2020</h3>
                        </a>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga veritatis veniam corrupti perferendis.</p>
                        <a class="read-more" href="news-details.html">
                            Read More
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/news/2.jpg" alt="Image">
                        </a>
                        <div class="dates">
                            <span>PRICE</span>
                        </div>
                    </div>
                    <div class="news-content-wrap">
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="flaticon-user"></i>
                                    Admin
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="flaticon-conversation"></i>
                                    Comment
                                </a>
                            </li>
                        </ul>
                        <a href="news-details.html">
                            <h3>A Perfect Day With Businessman At Ecorik Hotel</h3>
                        </a>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga veritatis veniam corrupti perferendis.</p>
                        <a class="read-more" href="news-details.html">
                            Read More
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/news/1.jpg" alt="Image">
                        </a>
                        <div class="dates">
                            <span>STORE</span>
                        </div>
                    </div>
                    <div class="news-content-wrap">
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="flaticon-user"></i>
                                    Admin
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="flaticon-conversation"></i>
                                    Comment
                                </a>
                            </li>
                        </ul>
                        <a href="news-details.html">
                            <h3>Celebrating Decade Years Of Hotel In 2019</h3>
                        </a>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga veritatis veniam corrupti perferendis.</p>
                        <a class="read-more" href="news-details.html">
                            Read More
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End News Area -->

<!-- Start City View Area -->
<section class="city-view-area ptb-100">
    <div class="container">
        <div class="city-wrap">
            <div class="single-city-item owl-carousel owl-theme">
                <div class="city-view-single-item">
                    <div class="city-content">
                        <span>The City View</span>
                        <h3>A charming view of the city town</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur necessitatibus fugit eligendi accusantium vel quos debitis cupiditate ducimus placeat explicabo distinctio, consectetur eos animi, a voluptate delectus. Id, explicabo saepe Consequuntur</p>

                        <p>The view onin wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ad minim veniam, quis nostrud exercitation consectetur.</p>
                    </div>
                </div>
                <div class="city-view-single-item">
                    <div class="city-content">
                        <span>The City View</span>
                        <h3>The charming view of the city</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur necessitatibus fugit eligendi accusantium vel quos debitis cupiditate ducimus placeat explicabo distinctio, consectetur eos animi, a voluptate delectus. Id, explicabo saepe Consequuntur</p>

                        <p>The view onin wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ad minim veniam, quis nostrud exercitation consectetur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End City View Area -->


<!-- Start Restaurants Area -->
<section class="restaurants-area pb-100">
    <div class="container-fluid p-0">
        <div class="section-title">
            <span>Restaurants</span>
            <h2>The area we cover under Ecorik</h2>
        </div>

        <div class="restaurants-wrap owl-carousel owl-theme">
            <div class="single-restaurants bg-1">
                <i class="restaurants-icon flaticon-coffee-cup"></i>
                <span>Restaurants</span>
                <p>Restaurant wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaua. Ut nipor incididuit might br minim veniam.</p>
                <a href="#" class="default-btn">
                    Explore More
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-2">
                <i class="restaurants-icon flaticon-swimming"></i>
                <span>Swimming Pool</span>
                <p>Restaurant wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaua. Ut nipor incididuit might br minim veniam.</p>
                <a href="#" class="default-btn">
                    Explore More
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-3">
                <i class="restaurants-icon flaticon-speaker"></i>
                <span>Conference Room</span>
                <p>Restaurant wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaua. Ut nipor incididuit might br minim veniam.</p>
                <a href="#" class="default-btn">
                    Explore More
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-4">
                <i class="restaurants-icon flaticon-podium"></i>
                <span>Best Rate</span>
                <p>Restaurant wansis dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaua. Ut nipor incididuit might br minim veniam.</p>
                <a href="#" class="default-btn">
                    Explore More
                    <i class="flaticon-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End Restaurants Area -->

<!-- start Testimonials Area -->
<section class="testimonials-area pb-100">
    <div class="container">
        <div class="section-title">
            <span>Testimonials</span>
            <h2>What customers say</h2>
        </div>
        <div class="testimonials-wrap owl-carousel owl-theme">
            <div class="single-testimonials">
                <ul>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                </ul>
                <h3>Excellent Room</h3>
                <p>“Awesome yksum dolor sit ametco elit, sed do eiusmod tempor incididunt et md do eiusmoeiusmod tempor inte emamnsecacing eiusmoeiusmod”</p>
                <div class="testimonials-content">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/testimonials/2.jpg" alt="Image">
                    <h4>Ayman Jenis</h4>
                    <span>CEO@Leasuely</span>
                </div>
            </div>
            <div class="single-testimonials">
                <ul>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                </ul>
                <h3>Excellent hotel</h3>
                <p>“Awesome yksum dolor sit ametco elit, sed do eiusmod tempor incididunt et md do eiusmoeiusmod tempor inte emamnsecacing eiusmoeiusmod”</p>
                <div class="testimonials-content">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/testimonials/3.jpg" alt="Image">
                    <h4>Ayman Jenis</h4>
                    <span>CEO@Leasuely</span>
                </div>
            </div>
            <div class="single-testimonials">
                <ul>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                    <li>
                        <i class="bx bxs-star"></i>
                    </li>
                </ul>
                <h3>Excellent Swimming</h3>
                <p>“Awesome yksum dolor sit ametco elit, sed do eiusmod tempor incididunt et md do eiusmoeiusmod tempor inte emamnsecacing eiusmoeiusmod”</p>
                <div class="testimonials-content">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/testimonials/1.jpg" alt="Image">
                    <h4>Ayman Jenis</h4>
                    <span>CEO@Leasuely</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Testimonials Area -->



<?php include_once 'views/template/footer-principal.php'; 

if (!empty($_GET['respuesta']) && $_GET['respuesta' == 'warning']) { ?>

<script>
    alertaSW('Todos los campos son requeridos', 'warning');
</script>

<?php } ?>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/index.js'; ?>"></script>

</body>

</html> 