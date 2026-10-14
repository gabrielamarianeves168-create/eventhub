<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => true,
        ];

        if (Auth::attemp(
            $credentials,
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('events.index'))
                ->with(
                    'success',
                    'Login realizado com sucesso.'
                );
        }

        return back()
            ->withErros([
                'email' => 'E-mail ou senha inválidos'
            ])
            ->onlyInput('email');
    }

    public function register(RegisterRequest $request): RedirectResponse {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make(

    request->input('password')), 'role'=>'user', 'status' => true,]);
        Auth::login(user);

        $request->session()->regenerate();

        return redirect()
            ->route('events.idex')
            ->with(
                'success',
                'Conta criada com sucesso'
            );
    }

    public function logout(
        \Illuminate\Http\Request $request
    ): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();

        $request->session->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'vc saiu do sistema'
            );
    }
}
