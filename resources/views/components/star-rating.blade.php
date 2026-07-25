@props(['rating' => 5, 'size' => 12])

@php
    $rounded = (int) round($rating);
@endphp

<div {{ $attributes->merge(['class' => 'flex gap-0.5']) }}>
    @for ($i = 1; $i <= 5; $i++)
        <x-lucide
            name="star"
            :size="$size"
            @class([
                'fill-amber-400 text-amber-400' => $i <= $rounded,
                'fill-gray-200 text-gray-200' => $i > $rounded,
            ])
        />
    @endfor
</div>
