<x-filament-panels::page>

    {{-- Event Selection --}}
    <x-filament::section>
        <x-slot name="heading">
            Event Selection
        </x-slot>

        {{ $this->form }}

    </x-filament::section>


    {{-- User Behavior --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">
            User Attendance Behavior
        </x-slot>

        @livewire(
            \App\Filament\Widgets\UserAttendanceBehaviorStats::class,
            [
                'eventOccurrenceId' => $this->eventOccurrenceId
            ]
        )

    </x-filament::section>

        {{-- Attendance Analytics --}}
        @livewire(
            \App\Filament\Widgets\AttendanceByDayChart::class,
            [
                'eventOccurrenceId' => $this->eventOccurrenceId
            ]
        )


</x-filament-panels::page>