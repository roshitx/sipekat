@props(['disabled' => false, 'placeholder' => null])

<input {{ $disabled ? 'disabled' : '' }} placeholder="{{ $placeholder ? $placeholder : ''}}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm transition-all duration-300 ease-in-out']) !!}>
