<x-page title="Mi perfil">
    <div class="row g-4">
        <div class="col-lg-4" data-reveal="left">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <i class="bi bi-person-circle display-3 text-brand"></i>
                <h2 class="h4 mt-2 mb-0">{{ $user->name }}</h2>
                <p class="text-body-secondary">{{ $user->email }}</p>
                <p class="mb-3"><span class="badge text-bg-light">{{ $user->isAdmin() ? 'Administrador' : 'Cliente' }}</span></p>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">
                    <i class="bi bi-receipt me-1"></i> Mis pedidos <span class="badge text-bg-dark ms-1">{{ $ordersCount }}</span>
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4" data-reveal="right">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Mis datos</h2>
                    <form method="post" action="{{ route('profile.update') }}" class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   @class(['form-control', 'is-invalid' => $errors->profile->has('name')])>
                            <div class="invalid-feedback">{{ $errors->profile->first('name') }}</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   @class(['form-control', 'is-invalid' => $errors->profile->has('email')])>
                            <div class="invalid-feedback">{{ $errors->profile->first('email') }}</div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-brand">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4" data-reveal="right">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Cambiar contraseña</h2>
                    <form method="post" action="{{ route('profile.password') }}" class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-md-4">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <input type="password" id="current_password" name="current_password" required
                                   @class(['form-control', 'is-invalid' => $errors->password->has('current_password')])>
                            <div class="invalid-feedback">{{ $errors->password->first('current_password') }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input type="password" id="password" name="password" required
                                   @class(['form-control', 'is-invalid' => $errors->password->has('password')])>
                            <div class="invalid-feedback">{{ $errors->password->first('password') }}</div>
                        </div>
                        <div class="col-md-4">
                            <label for="password_confirmation" class="form-label">Confirmar</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-dark">Cambiar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-page>
