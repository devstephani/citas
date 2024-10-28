<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        @php
            $sliders = ['img/sliders/cp1.jpg', 'img/sliders/fondo_1.jpeg', 'img/sliders/pigmento.jpg'];
        @endphp
        @foreach ($sliders as $slider)
            <div class="eorik-slider-item" style="background-image: url({{ asset($slider) }}">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="eorik-slider-text overflow-hidden one eorik-slider-text-one">
                                <h1>Browslashes_stefy</h1>
                                <span>En nuestro salón, no solo transformamos tu apariencia, sino también tu
                                    autoestima</span>
                                <div class="slider-btn">
                                    <a class="default-btn" href="https://www.instagram.com/browslashes_stefy/">
                                        Mas informacion
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
