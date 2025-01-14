<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-padrao text-white fw-semibold d-block w-100']) }}>
    {{ $slot }}
</button>
