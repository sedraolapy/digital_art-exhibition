<x-filament-panels::page>

    {{-- Event Selection --}}
    <x-filament::section>
        <x-slot name="heading">
            Event Selection
        </x-slot>

        {{ $this->form }}

    </x-filament::section>


    {{-- Overview --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Event Overview
        </x-slot>

        @livewire(
            \App\Filament\Widgets\EventOverviewStats::class,
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

        {{-- Lecture Performance --}}

    @livewire(
        \App\Filament\Widgets\LecturePerformanceTable::class,
        [
            'eventOccurrenceId' => $this->eventOccurrenceId
        ]
    )



</x-filament-panels::page>