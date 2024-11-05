@props(['comments'])

<section class="testimonials-area pb-100">
    <div class="container">
        <div class="section-title">
            <span>Testimonials</span>
            <h2>Nuestros clientes dicen</h2>
        </div>
        <div class="testimonials-wrap owl-carousel owl-theme">
            @foreach ($comments as $comment)
                <div class="single-testimonials">
                    <p class="max-w-[30px]">"{{ $comment->content }}"</p>
                    <div class="testimonials-content">
                        <h4>{{ $comment->user->name }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
