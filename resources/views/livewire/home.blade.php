<section class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
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
