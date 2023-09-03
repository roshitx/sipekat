@props(['disabled' => false, 'placeholder' => null, 'value' => null, 'rows' => ''])

<textarea {{ $disabled ? 'disabled' : '' }} placeholder="{{ $placeholder ? $placeholder : ''}}" rows="{{ $rows }}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm transition-all duration-300 ease-in-out']) !!}>{{ $value ? $value : old('description') }}</textarea>
