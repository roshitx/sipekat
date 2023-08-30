@props(['options', 'selected' => false, 'name' => ''])

<select name="{{ $name }}" {{ $attributes->merge(['class' => 'border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm']) }}>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $value === $selected ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>
