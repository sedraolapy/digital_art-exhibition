<x-filament-panels::page>

    <x-filament::section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <x-filament::input.wrapper>
                <select
                    wire:model.live="channel"
                    class="fi-select-input block w-full border-0 bg-transparent py-1.5 text-base text-gray-950 outline-none focus:ring-0 dark:text-white"
                >
                    <option value="security">Security</option>
                    <option value="audit">Audit</option>
                    <option value="performance">Performance</option>
                </select>
            </x-filament::input.wrapper>

            <x-filament::input.wrapper>
                <input
                    type="date"
                    wire:model.live="date"
                    class="fi-input block w-full border-0 bg-transparent py-1.5 text-base text-gray-950 outline-none focus:ring-0 dark:text-white"
                >
            </x-filament::input.wrapper>

            <x-filament::input.wrapper>
                <input
                    type="text"
                    wire:model.live.debounce.500ms="search"
                    placeholder="Search logs..."
                    class="fi-input block w-full border-0 bg-transparent py-1.5 text-base text-gray-950 outline-none focus:ring-0 dark:text-white"
                >
            </x-filament::input.wrapper>

        </div>

    </x-filament::section>


    <x-filament::section class="mt-6">

        <div class="rounded-xl bg-gray-950 p-4 overflow-auto max-h-[600px]">

            <pre class="text-sm text-gray-200 whitespace-pre-wrap font-mono">{{ $this->getLogContent() }}</pre>

        </div>

    </x-filament::section>

</x-filament-panels::page>