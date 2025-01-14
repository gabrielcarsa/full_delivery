@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label m-0 fw-medium']) }}>
    {{ $value ?? $slot }}
</label>
