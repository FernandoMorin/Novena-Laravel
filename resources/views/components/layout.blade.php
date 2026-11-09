@props(['title' => 'Novena Studio'])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title }}</title>
    {{-- Las animaciones de entrada solo se activan si hay JS; sin JS todo se ve normal. --}}
    <script>document.documentElement.classList.add('js')</script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"/>
</head>
<body @class(['login-open' => $errors->login->any() || $errors->register->any() || (request()->boolean('login') && auth()->guest())])>

@guest
    <x-login-overlay />
@endguest

<x-navbar />

{{ $slot }}

<x-flash />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
