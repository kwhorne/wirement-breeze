@props([
    'data'
])
<a x-data="{}"
    x-on:click.prevent="window.navigator.clipboard.writeText(@js($data));$tooltip('{{ __('wirement-breeze::default.clipboard.tooltip') }}');"
    href="#" class="flex items-center">
    @svg('heroicon-s-clipboard-document', 'w-4 mr-2')
    <span class="">{{ __('wirement-breeze::default.clipboard.link') }}</span>
</a>
