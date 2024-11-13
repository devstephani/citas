@section('page-title')
    {{ $title }}
@endsection

<div>
    @role('client')
        <x-page-title :title="$title" :subtitle="$subtitle" />
        <section class="exclusive-offers-area-four pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <span>Exclusive Offers</span>
                    <h2>You can get an exclusive offer</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="single-exclusive-four">
                            <img src="{{ asset('img/exclusive/7.jpg') }}" alt="Image">
                            <div class="exclusive-content">
                                <span class="title">Up To 30% Off</span>
                                <h3>Swimming for man</h3>
                                <span class="review">
                                    4.5
                                    <a href="#">(432 Reviews)</a>
                                </span>
                                <p>Swimming doller dolor sit aet odu tur adiing elitse</p>
                                <ul>
                                    <li>
                                        <i class="bx bx-time"></i>
                                        Duration: 2 Hours
                                    </li>
                                    <li>
                                        <i class="bx bx-target-lock"></i>
                                        18+ years
                                    </li>
                                </ul>
                                <a href="book-table.html" class="default-btn">
                                    Book Online
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="single-exclusive-four">
                            <img src="{{ asset('img/exclusive/8.jpg') }}" alt="Image">
                            <div class="exclusive-content">
                                <span class="title">This Month Only</span>
                                <h3>$5 Breakfast package</h3>
                                <span class="review">
                                    5.0
                                    <a href="#">(580 Reviews)</a>
                                </span>
                                <p>Start $5 doller dolor sit aet odeu tur adiing elitse</p>
                                <ul>
                                    <li>
                                        <i class="bx bx-time"></i>
                                        Duration: 2 Hours
                                    </li>
                                    <li>
                                        <i class="bx bx-target-lock"></i>
                                        18+ years
                                    </li>
                                </ul>
                                <a href="book-table.html" class="default-btn">
                                    Book Online
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 offset-sm-3 offset-lg-0">
                        <div class="single-exclusive-four">
                            <img src="{{ asset('img/exclusive/9.jpg') }}" alt="Image">
                            <div class="exclusive-content">
                                <span class="title">30% OFFonly This Week</span>
                                <h3>Free fitness club for women</h3>
                                <span class="review">
                                    4.9
                                    <a href="#">(580 Reviews)</a>
                                </span>
                                <p>Start $5 doller dolor sit aet odeu tur adiing elitse</p>
                                <ul>
                                    <li>
                                        <i class="bx bx-time"></i>
                                        Duration: 2 Hours
                                    </li>
                                    <li>
                                        <i class="bx bx-target-lock"></i>
                                        18+ years
                                    </li>
                                </ul>
                                <a href="book-table.html" class="default-btn">
                                    Book Online
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Exclusive Offers Area -->

        <!-- Start facilities Area -->
        <section class="facilities-area-four">
            <div class="container">
                <div class="section-title">
                    <span>facilities</span>
                    <h2>Giving entirely awesome</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-speaker"></i>
                            <h3>Meetings & Special Events</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-coffee-cup"></i>
                            <h3>Welcome Drink</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-garage"></i>
                            <h3>Parking Space</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-water"></i>
                            <h3>Cold & Hot Water</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-pickup"></i>
                            <h3>Pick Up & Drop</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="singles-facilities">
                            <i class="flaticon-swimming"></i>
                            <h3>Swimming Pool</h3>
                            <p>Morem ipsum dol sitamcectur Risus commodo vivercs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End facilities Area -->

        <!-- Start Our Rooms Area -->
        <section class="our-rooms-area-two our-rooms-area-four">
            <div class="container">
                <div class="section-title">
                    <span>Our Rooms</span>
                    <h2>Fascinating rooms & suites</h2>
                </div>
                <div class="tab industries-list-tab">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="tabs row">
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-online-booking"></i>
                                        <span class="booking-title">Free cost</span>
                                        <h3>No booking fee</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-podium"></i>
                                        <span class="booking-title">Free cost</span>
                                        <h3>Best rate guarantee</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-airport"></i>
                                        <span class="booking-title">Free cost</span>
                                        <h3>Reservations 24/7</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-slow"></i>
                                        <span class="booking-title">Free cost</span>
                                        <h3>High-speed Wi-Fi</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-coffee-cup-1"></i>
                                        <span class="booking-title">Free cost</span>
                                        <h3>Free breakfast</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 single-tab">
                                    <div class="single-rooms">
                                        <i class="flaticon-user"></i>
                                        <span class="booking-title">100% free</span>
                                        <h3>One person free</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="tab_content">
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-1">
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-2">
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-3">
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-4">
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-5">
                                    </div>
                                </div>
                                <div class="tabs_item">
                                    <div class="our-rooms-single-img room-bg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endrole

    @hasanyrole(['admin', 'employee'])
        <div class="relative overflow-x-auto">
            <div class="flex flex-col sm:flex-row justify-between gap-3">

                <x-search />
                <div class="py-4 px-4 sm:p-4">
                    <livewire:package-modal />
                </div>
            </div>

            <div class="p-4 overflow-x-auto shadow-md">
                <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                    <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Imágen
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descripción
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Servicios
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Publicado por
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Activo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $package)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="{{ asset('storage/' . $package->image) }}" class="size-20 rounded-md" />
                                </th>
                                <td class="px-6 py-4">
                                    {{ $package->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->description }}
                                </td>
                                <td class="px-6 py-4">
                                    <ul class="flex flex-col gap-2">
                                        @foreach ($package->services as $service)
                                            <li class="list-disc">{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->price }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($package->active)
                                        <x-lucide-circle-check
                                            wire:click="$dispatch('toggle_active', { package: {{ $package->id }} })"
                                            class="cursor-pointer size-5 text-green-700" />
                                    @else
                                        <x-lucide-circle-slash
                                            wire:click="$dispatch('toggle_active', { package: {{ $package->id }} })"
                                            class="cursor-pointer size-5 text-red-700" />
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <x-lucide-pencil class="size-5 hover:text-blue-600 cursor-pointer"
                                            wire:click="$dispatch('edit', { record: {{ $package->id }}})" />
                                        @role('admin')
                                            <x-lucide-trash class="size-5 hover:text-blue-600 cursor-pointer"
                                                onclick="delete_alert({{ $package->id }})" />
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $packages->links() }}
                @if (count($packages) === 0)
                    <p class="text-center">No se encontraron registros</p>
                @endif
            </div>
        </div>
    @endhasallroles
</div>
