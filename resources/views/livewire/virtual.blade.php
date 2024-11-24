@section('page-title')
    Probador virtual
@endsection

<div>
    @role('client')
        <x-page-title :title="$title" :subtitle="$subtitle" />
    @endrole

    @if ($show_alert)
        <div class="max-w-sm mx-auto text-justify">
            <x-alert>
                {{ session('alert') }}
            </x-alert>
        </div>
    @endif

    <div x-data="{
        eyelashesX: @entangle('eyeslashes_position.x'),
        eyelashesY: @entangle('eyeslashes_position.y'),
        browslashesX: @entangle('browslashes_position.x'),
        browslashesY: @entangle('browslashes_position.y'),
    }" class="p-12 w-full mx-auto flex items-center">
        <div class="mx-auto flex gap-3">
            <div class="flex flex-col gap-4 max-w-80">
                <section class="mx-auto border rounded-md border-neutral-400 p-4 flex flex-col items-center relative">
                    <img src="{{ asset('img/templates/face.png') }}" alt="Imágen de cara" class="mx-auto size-96">

                    @if (!empty($selected_eyeslashes) && $selected_eyeslashes !== '')
                        <img src="{{ asset($selected_eyeslashes) }}" alt=""
                            class="mx-auto w-36 h-12 absolute z-10"
                            x-bind:style="'top: ' + eyelashesY + '%; left: ' + eyelashesX + '%;'">
                    @endif
                    @if (!empty($selected_browslashes) && $selected_browslashes !== '')
                        <img src="{{ asset($selected_browslashes) }}" alt=""
                            class="mx-auto w-36 h-12 absolute z-10"
                            x-bind:style="'top: ' + browslashesY + '%; left: ' + browslashesX + '%;'">
                    @endif
                </section>
                <div class="flex flex-col mx-auto gap-3">
                    <x-button wire:click="$dispatch('toggle', { side: 'eyeslashes' })">
                        Seleccionar cejas
                    </x-button>
                    <x-button wire:click="$dispatch('toggle', { side: 'browslashes' })">
                        Seleccionar pestañas
                    </x-button>
                    <x-button wire:click="save" class="text-center">
                        Guardar imágen
                    </x-button>
                    <x-button wire:click="resetUI" class="text-center">
                        Limpiar
                    </x-button>
                </div>
            </div>
            @if ($show_template)
                <section
                    class="w-full max-w-96 max-h-fit border rounded-md border-neutral-400 p-4 flex flex-col items-center">
                    <div class="flex flex-wrap gap-3">
                        @if ($eyeslashes)
                            @foreach ($eyeslashes_images as $img)
                                <img src="{{ $img }}" alt=""
                                    wire:click="$dispatch('toggle_images', { image: '{{ $img }}', side: 'eyeslashes'})"
                                    @class([
                                        'size-16 p-2 cursor-pointer hover:border hover:border-blue-500 hover:scale-110',
                                        'shadow border border-blue-300' => $selected_eyeslashes === $img,
                                    ])>
                            @endforeach

                            <div class="flex justify-between gap-3">
                                <div class="">
                                    <x-label value="Posición x" for="eyeslashesX" />
                                    <input type="range" wire:model.lazy="eyeslashes_position.x" min="0"
                                        max="100" id="eyeslashesX" class="w-full" />
                                </div>
                                <div class="">
                                    <x-label value="Posición y" for="eyeslashesY" />
                                    <input type="range" wire:model.lazy="eyeslashes_position.y" min="0"
                                        max="100" id="eyeslashesY" class="w-full" />
                                </div>
                            </div>
                        @endif
                        @if ($browslashes)
                            @foreach ($browslashes_images as $img)
                                <img src="{{ $img }}" alt=""
                                    wire:click="$dispatch('toggle_images', { image: '{{ $img }}', side: 'browslashes'})"
                                    @class([
                                        'size-16 p-2 cursor-pointer hover:border hover:border-blue-500 hover:scale-110',
                                        'shadow border border-blue-300' => $selected_browslashes === $img,
                                    ])>
                            @endforeach

                            <div class="flex justify-between gap-3">
                                <div class="">
                                    <x-label value="Posición x" for="browslashes_x" />
                                    <input type="range" wire:model.lazy="browslashes_position.x" min="0"
                                        max="100" id="browslashes_x" class="w-full" />
                                </div>
                                <div class="">
                                    <x-label value="Posición y" for="browslashes_y" />
                                    <input type="range" wire:model.lazy="browslashes_position.y" min="0"
                                        max="100" id="browslashes_y" class="w-full" />
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endif
        </div>

    </div>
</div>
