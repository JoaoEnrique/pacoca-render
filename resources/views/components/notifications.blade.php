{{-- MENSAGEM SUCESSO --}}
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible alert-account fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- MENSAGEM DE ERRO --}}
@if(session()->has('danger'))
<div class="alert alert-danger alert-dismissible alert-account fade show" role="alert">
    {{session('danger')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
