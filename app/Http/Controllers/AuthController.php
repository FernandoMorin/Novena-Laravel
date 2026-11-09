<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors(['email' => 'Correo o contraseña incorrectos'], 'login')->onlyInput('email');
        }

        $request->session()->regenerate();

        // intended: si lo mandaron a iniciar sesión desde /perfil o /mis-pedidos, regresa ahí.
        return redirect()->intended(url()->previous())->with('status', '¡Hola de nuevo, '.$request->user()->name.'!');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(url()->previous())->with('status', '¡Bienvenido a Novena Studio, '.$user->name.'!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
