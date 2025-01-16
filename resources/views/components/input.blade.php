@props(['disabled' => false, 'name' => ''])

<input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" id="{{ $name }}" {!! $attributes->merge(['class' =>
$errors->has($name) ? 'form-control is-invalid' : 'form-control']) !!}>

@if ($errors->has($name))
<div class="invalid-feedback">
    {{ $errors->first($name) }}
</div>
@endif