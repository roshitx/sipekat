<a href="{{ $href }}" {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-primary']) }}>
    {{ $slot }}
</a>
