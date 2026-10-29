{{-- Bloque del panel admin con su mensaje de éxito (sesión) y sus errores (error bag). --}}
@props(['title', 'status', 'bag'])

<div {{ $attributes->class('admin-block') }}>
    <h2>{{ $title }}</h2>

    @session($status)
        <p class="admin-success">{{ $value }}</p>
    @endsession

    @if ($errors->getBag($bag)->any())
        <p class="admin-error">{{ $errors->getBag($bag)->first() }}</p>
    @endif

    {{ $slot }}
</div>
