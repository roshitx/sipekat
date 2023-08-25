@props(['disabled' => false, 'placeholder' => null, 'value' => null])

<textarea {{ $disabled ? 'disabled' : '' }} placeholder="{{ $placeholder ? $placeholder : ''}}" rows="5" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm']) !!}>{{ $value ? $value : old('description') }}</textarea>
