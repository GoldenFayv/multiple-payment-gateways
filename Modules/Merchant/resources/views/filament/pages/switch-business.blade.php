<x-filament-panels::page>
    <x-filament::section heading="Switch Active Business">
        <form wire:submit="switch">
            {{ $this->form }}
            <div class="mt-4">
                <x-filament::button type="submit">
                    Switch Business
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
