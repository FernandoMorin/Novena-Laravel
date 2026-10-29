<header class="navbar">
    <div class="header-left">
        <a href="{{ route('home') }}#home" class="brand">
            <span class="brand-main">Novena</span><span class="brand-sub">Studio</span>
        </a>
    </div>

    <div class="header-center">
        <nav class="menu">
            <a href="{{ route('home') }}#home">HOME</a>
            <a href="{{ route('home') }}#about">ABOUT</a>
            <a href="{{ route('store') }}" @class(['active' => request()->routeIs('store')])>PRODUCTOS</a>
        </nav>
    </div>

    <div class="header-right">
        @guest
            <a href="#" class="btn-login">INICIA SESIÓN</a>
        @else
            @can('admin')
                <a href="{{ route('admin.index') }}" class="btn-admin">Panel admin</a>
            @endcan

            <span class="user-label">
                Hola, {{ auth()->user()->name }} ({{ auth()->user()->isAdmin() ? 'Admin' : 'Usuario' }})
            </span>
            <form method="post" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        @endguest
    </div>
</header>
