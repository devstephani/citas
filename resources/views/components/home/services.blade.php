@props(['packages'])

<section class="our-rooms-area pt-60 pb-100">
    <div class="container">
        <div class="w-full">
            <div class="w-full section-title mx-auto text-center">
                <span>SERVICIOS</span>
                <h2>Paquetes</h2>
            </div>
        </div>
        <div class="tab industries-list-tab">
            <div class="row">
                @foreach ($packages as $package)
                    <a href="{{ route('packages') }}">
                        <div class="col-4 mt-2">
                            <ul class="tabs">
                                <li class="single-rooms rounded-md">
                                    <img loading="lazy" src="{{ asset('storage/' . $package->image) }}" alt="Image">
                                    <div class="room-content">
                                        <h3>{{ $package->name }}</h3>
                                        <span>${{ $package->price }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
