@inject('cart', 'App\Services\Cart')
@php($cartCount = $cart->count())

<header class="navbar">
    <div class="header-left">
        {{-- En pantallas chicas el menú se oculta (styles.css) y se abre como offcanvas de Bootstrap. --}}
        <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile-menu" aria-controls="mobile-menu" aria-label="Abrir menú">
            <i class="bi bi-list"></i>
        </button>
        <a href="{{ route('home') }}#home" class="brand">
            <span class="brand-main">Novena</span><span class="brand-sub">Studio</span>
        </a>
    </div>

    <div class="header-center">
        <nav class="menu">
            <a href="{{ route('home') }}#home">HOME</a>
            <a href="{{ route('home') }}#about">ABOUT</a>
            <a href="{{ route('store') }}" @class(['active' => request()->routeIs('store', 'products.show')])>PRODUCTOS</a>
        </nav>
    </div>

    <div class="header-right">
        <a href="{{ route('cart.index') }}" class="header-cart" aria-label="Carrito ({{ $cartCount }})">
            <i class="bi bi-bag"></i>
            @if ($cartCount > 0)
                <span class="badge rounded-pill bg-danger">{{ $cartCount }}</span>
            @endif
        </a>

        @guest
            <a href="#" class="btn-login">INICIA SESIÓN</a>
        @else
            <div class="dropdown">
                <button class="user-menu dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Mi perfil</a></li>
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-receipt me-2"></i>Mis pedidos</a></li>
                    @can('admin')
                        <li><a class="dropdown-item" href="{{ route('admin.index') }}"><i class="bi bi-speedometer2 me-2"></i>Panel admin</a></li>
                    @endcan
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endguest
    </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-menu" aria-labelledby="mobile-menu-label">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title brand" id="mobile-menu-label">
            <span class="brand-main">Novena</span><span class="brand-sub">Studio</span>
        </h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="nav flex-column mobile-menu">
            <a class="nav-link" href="{{ route('home') }}#home">Home</a>
            <a class="nav-link" href="{{ route('home') }}#about">About</a>
            <a class="nav-link" href="{{ route('store') }}">Productos</a>
            <a class="nav-link" href="{{ route('cart.index') }}">Carrito</a>
            @auth
                <a class="nav-link" href="{{ route('orders.index') }}">Mis pedidos</a>
                <a class="nav-link" href="{{ route('profile.edit') }}">Mi perfil</a>
            @endauth
        </nav>
    </div>
</div>
