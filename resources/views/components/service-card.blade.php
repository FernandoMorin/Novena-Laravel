@props(['title'])

<article class="service-card">
    <header class="service-head">
        <img src="{{ asset('Recursos/flecha1.png') }}" alt="" class="ico-diagonal" />
        <h3>{{ $title }}</h3>
    </header>
    <p class="service-desc">{{ $slot }}</p>
    <footer class="service-cta">
        <span>Conoce más</span>
        <img src="{{ asset('Recursos/flecha2.png') }}" alt="" class="ico-straight" />
    </footer>
</article>
