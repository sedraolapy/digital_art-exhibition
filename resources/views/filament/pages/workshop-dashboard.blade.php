<x-filament-panels::page>

    {{ $this->form }}

    <x-filament-widgets::widgets
    :widgets="$this->getWidgets()"
    :columns="1"
    :data="$this->getWidgetData()"
/>

</x-filament-panels::page>