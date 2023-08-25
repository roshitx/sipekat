<a href="{{ $href }}" {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-neutral']) }}>
    {{ $slot }}
</a>
