<x-filament-panels::page>
    <x-filament::section heading="Email">
        <form wire:submit="updateEmail">
            {{ $this->emailForm }}
            @if (!auth()->user() instanceof \App\Models\Admin)
                <div style="display:flex; gap:8px; margin-top:16px;">
                    <x-filament::button type="submit">
                        Update Email
                    </x-filament::button>
                </div>
            @endIf
        </form>
    </x-filament::section>

    <x-filament::section heading="Change Password">
        <form wire:submit="updatePassword">
            {{ $this->passwordForm }}
            <div style="display:flex; gap:8px; margin-top:16px;">
                <x-filament::button type="submit">
                    Update Password
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
