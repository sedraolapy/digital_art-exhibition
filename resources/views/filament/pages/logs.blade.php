<x-filament-panels::page>

    {{-- Filters --}}
    <x-filament::section>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Channel --}}
            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-950 dark:text-white mb-2">
                    Channel
                </label>

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
            </div>
            <br>


            {{-- Date --}}
            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-950 dark:text-white mb-2">
                    Date
                </label>

                <x-filament::input.wrapper>
                    <input
                        type="date"
                        wire:model.live="date"
                        class="fi-input block w-full border-0 bg-transparent py-1.5 text-base text-gray-950 outline-none focus:ring-0 dark:text-white"
                    >
                </x-filament::input.wrapper>
            </div>

        </div>

    </x-filament::section>


    {{-- Logs --}}
    <x-filament::section class="mt-6">

    <div class="overflow-x-auto rounded-xl">

        <table class="w-full table-fixed text-sm">
    
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800">
    
                    <th
                        style="width: 140px;"
                        class="border border-gray-300 px-4 py-3 font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-300"
                    >
                        Level
                    </th>

                    <th
                        style="width: 220px;"
                        class="border border-gray-300 px-4 py-3 font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-300"
                    >
                        Date
                    </th>

                    <th
                        class="border border-gray-300 px-4 py-3 font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-300"
                    >
                        Message
                    </th>
    
                </tr>
            </thead>
    
            <tbody>

                @forelse ($this->getLogs() as $log)
            
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
            
                        {{-- Level --}}
                        <td
                            class="border border-gray-300 px-4 py-3 text-center align-middle dark:border-gray-600"
                        >
                            @php
                                $color = match ($log['level']) {
                                    'ERROR',
                                    'CRITICAL',
                                    'ALERT',
                                    'EMERGENCY' => 'danger',
            
                                    'WARNING' => 'warning',
            
                                    'INFO',
                                    'NOTICE' => 'success',
            
                                    default => 'gray',
                                };
                            @endphp
            
                            <div class="flex justify-center">
                                <x-filament::badge :color="$color">
                                    {{ $log['level'] }}
                                </x-filament::badge>
                            </div>
                        </td>
            
            
                        {{-- Date --}}
                        <td
                            class="border border-gray-300 px-4 py-3 text-center whitespace-nowrap align-middle text-gray-700 dark:border-gray-600 dark:text-gray-300"
                        >
                            {{ $log['datetime'] }}
                        </td>
            
            
                        {{-- Message --}}
                        <td
                            class="border border-gray-300 px-4 py-3 text-center align-middle break-words text-gray-950 dark:border-gray-600 dark:text-white"
                        >
                            {{ $log['message'] }}
                        </td>
            
                    </tr>
            
                @empty
            
                    <tr>
                        <td
                            colspan="3"
                            class="border border-gray-300 px-4 py-10 text-center text-gray-500 dark:border-gray-600 dark:text-gray-400"
                        >
                            No logs found.
                        </td>
                    </tr>
            
                @endforelse
            
            </tbody>
    
        </table>
    
    </div>

    </x-filament::section>

</x-filament-panels::page>