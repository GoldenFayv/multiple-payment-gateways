<x-filament-panels::page>
    <div class="max-w-md">
        <form wire:submit="verify">
            {{ $this->form }}

            <div style="display:flex; gap:8px; margin-top:16px;">
                <x-filament::button type="submit">
                    Verify Email
                </x-filament::button>

                <x-filament::button type="button" color="gray" wire:click="resend">
                    Resend Code
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
