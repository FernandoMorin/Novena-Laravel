@php($registerHasErrors = $errors->register->any())
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Novena Studio')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"/>
</head>
<body @class(['login-open' => $errors->login->any() || $registerHasErrors])>

@guest
    <div class="login-overlay" aria-hidden="true">
        <div class="login-sheet" role="dialog" aria-modal="true">
            <button class="login-close">✕</button>

            <!-- ===== LOGIN ===== -->
            <h3 class="login-title-login" @style(['display:none' => $registerHasErrors])>Inicia sesión</h3>
            <form class="login-form" method="post" action="{{ route('login') }}" @style(['display:none' => $registerHasErrors])>
                @csrf
                <label>
                    <span>Correo</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label>
                    <span>Contraseña</span>
                    <input type="password" name="password" required>
                </label>

                <button type="submit" class="btn-submit">Iniciar sesión</button>

                <div class="login-links">
                    <a href="#" class="link-register">Registrarme</a>
                </div>

                @error('email', 'login')
                    <p class="login-error">{{ $message }}</p>
                @enderror
            </form>

            <!-- ===== REGISTRO ===== -->
            <h3 class="login-title-register" @style(['display:none' => ! $registerHasErrors])>Crear cuenta</h3>
            <form class="register-form" method="post" action="{{ route('register') }}" @style(['display:none' => ! $registerHasErrors])>
                @csrf
                <label>
                    <span>Nombre</span>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </label>

                <label>
                    <span>Correo</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>

                <label>
                    <span>Contraseña</span>
                    <input type="password" name="password" required>
                </label>

                <label>
                    <span>Confirmar contraseña</span>
                    <input type="password" name="password_confirmation" required>
                </label>

                <button type="submit" class="btn-submit">Crear cuenta</button>

                <div class="login-links">
                    <a href="#" class="link-back-login">Ya tengo cuenta</a>
                </div>

                @if ($registerHasErrors)
                    <p class="login-error">{{ $errors->register->first() }}</p>
                @endif
            </form>
        </div>
    </div>
@endguest

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

@yield('content')

<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
