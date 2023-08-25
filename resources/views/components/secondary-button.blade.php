<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-neutral']) }}>
    {{ $slot }}
</button>
