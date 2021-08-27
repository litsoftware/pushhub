@props([
'src' => null,
'alt' => null,
])

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => '']) }}>
