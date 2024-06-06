<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        $dados = $request->only(['name', 'user_name', 'email', 'phone', 'password', 'site', 'biography', 'sexo', 'birth_date']);
        $dados['password'] = Hash::make($dados['password']);
        $dados_login = $request->only(['email', 'password']);


        $user = User::create($dados);
        // $this->setNotification($new_user->id, '../img/pacoca-fundo.png', 'Seja bem vindo ao Paçoca, sua nova rede social', '/pacoca', '/pacoca');

        // event(new Registered($user));

        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect()->intended(route('verification.notice'));

        return redirect('/')->with('mensagem', 'Conta criada. Um link de verificação de email foi enviado para eu email');
    }
}
