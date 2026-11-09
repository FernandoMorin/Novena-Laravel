{{-- Contenedor de las páginas del cliente (carrito, pedidos, perfil...): mismo fondo que la tienda.
     heading="" oculta el título cuando la página pone el suyo. --}}
@props(['title', 'heading' => null])

<x-layout :title="$title.' · Novena Studio'">
    <main class="page">
        <div {{ $attributes->class('container py-4') }}>
            @unless ($heading === '')
                <h1 class="page-title" data-reveal="left">{{ $heading ?? $title }}</h1>
            @endunless
            {{ $slot }}
        </div>
    </main>
</x-layout>
