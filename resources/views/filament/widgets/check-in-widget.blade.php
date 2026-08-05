<x-filament-widgets::widget>
    <x-filament::section >

        {{ $this->form }}
<br>
        <div class="mt-6">
            <x-filament::button
                wire:click="openCheckIn"
                icon="heroicon-o-qr-code"
            >
                Open Check-in
            </x-filament::button>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>