@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $errors->has('nome') ? 'form-control is-invalid' : 'form-control']) !!}>
