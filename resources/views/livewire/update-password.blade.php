<x-wirement-breeze::grid-section md=2 :title="__('wirement-breeze::default.profile.password.heading')" :description="__('wirement-breeze::default.profile.password.subheading')">
    <x-filament::card>
        <form wire:submit.prevent="submit" class="space-y-6">

            {{ $this->form }}

            <div class="text-right">
                <x-filament::button type="submit" form="submit" class="align-right">
                    {{ __('wirement-breeze::default.profile.password.submit.label') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>
</x-wirement-breeze::grid-section>
