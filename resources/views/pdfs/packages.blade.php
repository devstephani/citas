<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Reporte de servicios</title>
    <link rel="icon" type="image/x-icon" href="assets/img/Logoico.ico" />
    <link href="{{ public_path() . '/css/bootstrap.min.css' }}" rel="stylesheet" type="text/css">
</head>

<body class="dashboard-analytics">

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="mt-5 layout-px-spacing">

                <div class="text-center">
                    <img src="data:image/png;base64,{{ $image }}" class="navbar-logo img-fluid" alt="logo"
                        style="max-width: 75px;">
                    <p>
                        Browslashes Stefy
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-center text-white">Fecha</th>
                                <th class="table-th text-center text-white">Estado</th>
                                <th class="table-th text-center text-white">Cliente</th>
                                <th class="table-th text-center text-white">Servicio</th>
                                <th class="table-th text-center text-white">Precio</th>
                                <th class="table-th text-center text-white">Pagado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ \Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $package->picked_date)->format('d-m-Y h:i a') }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $package->status ? 'Pagado' : 'Pendiente' }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $package->user->name }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $package->package->name }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $package->package->price * ($package->discount ? 0.95 : 1) }}$
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $currency = $package->payment->currency->name ?? '';
                                            $payed = $package->payment->payed ?? '';
                                        @endphp
                                        <h6>{{ "$currency $payed" }}
                                        </h6>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--  END CONTENT AREA  -->


        </div>
        <!-- END MAIN CONTAINER -->
</body>

</html>
