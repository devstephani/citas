<section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="col-span-1 h-[30dvh] bg-white border border-neutral-300 rounded-md">
        <livewire:livewire-column-chart :column-chart-model="$client_bar_chart" />
    </div>
    <div class="col-span-1 h-[30dvh] bg-white border border-neutral-300 rounded-md">
        <livewire:livewire-column-chart :column-chart-model="$employee_bar_chart" />
    </div>
</section>
