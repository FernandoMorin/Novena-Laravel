{{-- Si el registro falló, el overlay abre directo en el formulario de registro. --}}
@php($showRegister = $errors->register->any())

<div class="login-overlay" aria-hidden="true">
    <div class="login-sheet" role="dialog" aria-modal="true">
        <button class="login-close">✕</button>

        <!-- ===== LOGIN ===== -->
        <h3 class="login-title-login" @style(['display:none' => $showRegister])>Inicia sesión</h3>
        <form class="login-form" method="post" action="{{ route('login') }}" @style(['display:none' => $showRegister])>
            @csrf
            <x-form.field label="Correo" type="email" name="email" :value="old('email')" required />
            <x-form.field label="Contraseña" type="password" name="password" required />

            <button type="submit" class="btn-submit">Iniciar sesión</button>

            <div class="login-links">
                <a href="#" class="link-register">Registrarme</a>
            </div>

            @error('email', 'login')
                <p class="login-error">{{ $message }}</p>
            @enderror
        </form>

        <!-- ===== REGISTRO ===== -->
        <h3 class="login-title-register" @style(['display:none' => ! $showRegister])>Crear cuenta</h3>
        <form class="register-form" method="post" action="{{ route('register') }}" @style(['display:none' => ! $showRegister])>
            @csrf
            <x-form.field label="Nombre" name="name" :value="old('name')" required />
            <x-form.field label="Correo" type="email" name="email" :value="old('email')" required />
            <x-form.field label="Contraseña" type="password" name="password" required />
            <x-form.field label="Confirmar contraseña" type="password" name="password_confirmation" required />

            <button type="submit" class="btn-submit">Crear cuenta</button>

            <div class="login-links">
                <a href="#" class="link-back-login">Ya tengo cuenta</a>
            </div>

            @if ($showRegister)
                <p class="login-error">{{ $errors->register->first() }}</p>
            @endif
        </form>
    </div>
</div>
