<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary d-block w-100']) }}>
    {{ $slot }}
</button>