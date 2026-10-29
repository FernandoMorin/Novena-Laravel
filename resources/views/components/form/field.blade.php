{{-- Campo de formulario con etiqueta: <x-form.field label="Precio" type="number" name="price" step="0.01" /> --}}
@props(['label', 'type' => 'text'])

<label>
    <span>{{ $label }}</span>
    @if ($type === 'textarea')
        <textarea rows="3" {{ $attributes->except('value') }}>{{ $attributes->get('value') }}</textarea>
    @else
        <input type="{{ $type }}" {{ $attributes }}>
    @endif
</label>
