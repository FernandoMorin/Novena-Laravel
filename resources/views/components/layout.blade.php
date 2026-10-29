@props(['title' => 'Novena Studio'])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"/>
</head>
<body @class(['login-open' => $errors->login->any() || $errors->register->any()])>

@guest
    <x-login-overlay />
@endguest

<x-navbar />

{{ $slot }}

<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
