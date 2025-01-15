@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'is-invalid']) }}>{{ $message }}</p>
@enderror
