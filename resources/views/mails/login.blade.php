@extends('layouts.main')
@section('title', 'Login Reaizado na sua conta')

@section('text')
    <h1>Detalhes do Login</h1>
    <p>Olá, {{ $user->name }}</p>
    <p>Você realizou um login hoje, se não foi você troque sua senha.</p>

    <h2>Detalhes da Sessão:</h2>
    {{-- <p>IP do usuário: {{ $session->ip_address }}</p>
    <p>Dispositivo: {{ $session->user_agent }}</p> --}}

    <p>Obrigado por usar nosso sistema.</p>
@endsection
