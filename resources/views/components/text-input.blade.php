@props(['disabled' => false])

<input  @disabled($disabled) {{ $attributes->merge(['class' => 'block min-w-0 grow bg-transparent py-1.5 pr-3 pl-2 text-base text-white border rounded-md focus:outline-none sm:text-sm/6']) }}>
