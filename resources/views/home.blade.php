@extends('layouts.app')

@section('content')
    <section class="hero" id="home">
        <video class="hero-video" autoplay muted playsinline>
            <source src="{{ asset('Recursos/background.mp4') }}" type="video/mp4"/>
            Tu navegador no soporta video HTML5.
        </video>
        <div class="hero-overlay" aria-hidden="true"></div>

        <div class="hero-layout">
            <div class="title-block">
                <h1 class="hero-title">
                    <span class="line-1">Diseña</span>
                    <span class="line-2">el <em>futuro</em></span>
                </h1>
            </div>

            <div class="cta-row">
                <img src="{{ asset('Recursos/flecha.png') }}" alt="Flecha decorativa" class="arrow-img">
                <a href="#about" class="cta-outline">Conócenos</a>
            </div>
        </div>
    </section>

    <!-- ================= ABOUT ================= -->
<section id="about" class="about">
    <div class="about-top">
        <div class="about-titlecard">
            <div class="about-title">
                <h2 class="about-line1">Acerca de</h2>
                <hr class="about-divider">
                <h2 class="about-line2">
                    <span class="about-novena">Novena</span>
                    <span class="about-studio">Studio</span>
                </h2>
            </div>
        </div>

        <figure class="about-media">
            <img src="{{ asset('Recursos/ref1.png') }}" alt="Bocetos de diseño industrial en mesa" />
        </figure>
    </div>

    <div class="about-bottom">
        <p class="about-paragraph">
            En Novena Studio unimos el diseño gráfico y el diseño industrial para transformar ideas en experiencias que inspiran.
            Nos apasiona crear proyectos donde la estética y la funcionalidad se encuentran, dando vida a productos, marcas y
            detalles que conectan con las personas. Cada diseño nace de la creatividad, la técnica y el deseo de innovar.
            En Novena Studio creemos que el diseño no solo embellece, también construye posibilidades.
        </p>
        <p class="about-tagline"><em>Diseña el futuro con nosotros.</em></p>
    </div>
</section>

<!-- ================= SERVICIOS ================= -->
<section id="servicios" class="services">
    <div class="services-inner">
        <div class="services-left">
            <h2 class="services-heading">
                <span>Nuestros</span>
                <span class="light">servicios</span>
            </h2>
        </div>

        <div class="services-right">

            <article class="service-card">
                <header class="service-head">
                    <img src="{{ asset('Recursos/flecha1.png') }}" alt="" class="ico-diagonal" />
                    <h3>Diseño gráfico</h3>
                </header>
                <p class="service-desc">
                    Branding, identidad visual, papelería corporativa y campañas impresas que capturan la personalidad de tu marca.
                </p>
                <footer class="service-cta">
                    <span>Conoce más</span>
                    <img src="{{ asset('Recursos/flecha2.png') }}" alt="" class="ico-straight" />
                </footer>
            </article>

            <article class="service-card">
                <header class="service-head">
                    <img src="{{ asset('Recursos/flecha1.png') }}" alt="" class="ico-diagonal" />
                    <h3>Diseño industrial</h3>
                </header>
                <p class="service-desc">
                    Creación de productos funcionales, mobiliario, prototipos y objetos con materiales seleccionados, pensando en la estética y la usabilidad.
                </p>
                <footer class="service-cta">
                    <span>Conoce más</span>
                    <img src="{{ asset('Recursos/flecha2.png') }}" alt="" class="ico-straight" />
                </footer>
            </article>

            <article class="service-card">
                <header class="service-head">
                    <img src="{{ asset('Recursos/flecha1.png') }}" alt="" class="ico-diagonal" />
                    <h3>Productos personalizados</h3>
                </header>
                <p class="service-desc">
                    Artículos únicos hechos a medida: invitaciones, packaging, regalos corporativos y decoración que se adapte a tu estilo.
                </p>
                <footer class="service-cta">
                    <span>Conoce más</span>
                    <img src="{{ asset('Recursos/flecha2.png') }}" alt="" class="ico-straight" />
                </footer>
            </article>

            <!-- item 4 -->
            <article class="service-card">
                <header class="service-head">
                    <img src="{{ asset('Recursos/flecha1.png') }}" alt="" class="ico-diagonal" />
                    <h3>Consultoría creativa</h3>
                </header>
                <p class="service-desc">
                    Acompañamiento desde la idea hasta la ejecución: dirección artística, materiales, acabados y conceptos que destaquen.
                </p>
                <footer class="service-cta">
                    <span>Conoce más</span>
                    <img src="{{ asset('Recursos/flecha2.png') }}" alt="" class="ico-straight" />
                </footer>
            </article>
        </div>
    </div>
</section>

@endsection
