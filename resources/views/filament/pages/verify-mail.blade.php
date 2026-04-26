<x-filament-panels::page.simple>
    <form wire:submit="verify">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full mt-4">
            Verify Email
        </x-filament::button>
    </form>
</x-filament-panels::page.simple>
