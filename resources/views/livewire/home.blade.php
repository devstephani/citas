@section('page-title')
    Inicio
@endsection

<div>
    @role('admin')
        <section class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="col-span-full place-self-end">
                <x-button type="button" wire:click="$dispatch('pdf')" class="w-full sm:w-fit gap-3">
                    <x-lucide-file-text class="size-5" />
                    Pagos
                </x-button>
            </div>
            <x-card title="Servicios" :value="$services_count" />
            <x-card title="Paquetes" :value="$packages_count" />
            <x-card title="Empleados" :value="$employees_count" />
            <x-card title="Clientes" :value="$clients_count" />
            <div class="col-span-1 sm:col-span-2 h-[60dvh] bg-white border border-neutral-300 rounded-md">
                <livewire:livewire-column-chart :column-chart-model="$client_bar_chart" />
            </div>
            <div class="col-span-1 sm:col-span-2 h-[60dvh] bg-white border border-neutral-300 rounded-md">
                <livewire:livewire-column-chart :column-chart-model="$employee_bar_chart" />
            </div>
        </section>
    @endrole
</div>
