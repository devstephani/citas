<div class="check-area mb-minus-70">
    <div class="container">
        <div class="check-btn check-content mb-0">
            <a href="{{ route('appointments') }}" class="default-btn">
                Agendar cita
                <i class="flaticon-right"></i>
            </a>
        </div>
        {{-- <form class="check-form" id="formulario" action="">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha de Llegada</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-1">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control !text-lg" id="f_reserva" name="f_reserva"
                                    value="{{ \Carbon\Carbon::now()->format('Y-M-D') }}">
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
                            <select name="hora" id="hora" class="select-auto" id="hora" style="width: 100%"
                                value = "">
                                <option value="">Seleccionar</option>
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
                                </option>
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
        </form> --}}
    </div>
</div>
