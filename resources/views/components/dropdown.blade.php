@props(['align' => 'right', 'width' => '56'])

@php
$alignmentClasses = match ($align) {
    'left' => 'left-0 origin-top-left',
    'top' => 'origin-top',
    default => 'right-0 origin-top-right',
};

$width = match ($width) {
    '48' => 'w-48',
    '56' => 'w-56',
    default => $width,
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false">

    {{-- Trigger --}}
    <div @click="open = ! open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Dropdown --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute {{ $alignmentClasses }} mt-4 {{ $width }}
                backdrop-blur-xl bg-white/90
                border border-gray-200
                rounded-2xl
                shadow-[0_10px_30px_rgba(0,0,0,0.08)]
                z-[999]"
         style="display: none;">

        <div class="py-3 px-2 text-sm text-gray-700 space-y-1">
            {{ $content }}
        </div>

    </div>

</div>
