@props(['packages'])

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
                        @foreach ($packages as $package)
                            <li class="single-rooms">
                                <img loading="lazy" src="{{ asset('storage/' . $package->image) }}" alt="Image">
                                <div class="room-content">
                                    <h3>{{ $package->name }}</h3>
                                    <span>${{ $package->price }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="tab_content">
                        @foreach ($packages as $index => $package)
                            <div class="tabs_item">
                                <div class="our-rooms-single-img room-bg-{{ $index + 1 }}">
                                    <p>

                                        {{ $package->description }}
                                    </p>

                                    <h6 class="mt-4 mb-2">
                                        Contiene los siguientes servicios:
                                    </h6>
                                    <ul class="flex flex-col">
                                        @foreach ($package->services as $service)
                                            <li>- {{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
