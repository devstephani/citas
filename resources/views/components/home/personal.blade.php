@props(['personal'])

<section class="news-area">
    <div class="container">
        <div class="section-title">
            <span>Presentacion</span>
            <h2>Empleados</h2>
        </div>
        <div class="row">
            @foreach ($personal as $employee)
                <div class="col-lg-4 col-md-6">
                    <div class="single-news">
                        <div class="news-img max-h-[32rem] h-auto">
                            <div style="display: flex; justify-content: center;">
                                <img style="width: 50%; border-radius: 10px" src="{{ $employee->get_image() }}"
                                    alt="Image">
                            </div>

                        </div>
                        <div class="news-content-wrap">
                            <h3>{{ $employee->user->name }}</h3>
                            <p>{{ $employee->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
