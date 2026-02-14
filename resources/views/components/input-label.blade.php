@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-base text-white']) }}>
    {{ $value ?? $slot }}
</label>
