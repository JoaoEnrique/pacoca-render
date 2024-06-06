<div class="modal fade" id="modal-curtida-{{$post->id}}" tabindex="-1" aria-labelledby="modal-curtida-{{$post->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-curtida-{{$post->id}}">Curtidas</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-curtida-body" style="overflow: auto; max-height: 70vh; min-height: 70vh; padding: 0 25px;">
                @foreach ($users_like as $user_like)
                    <div class="row account-search">

                        {{-- Imagem da conta no post --}}
                        @php
                            if($user_like->img_account){
                                $img_notification = $user_like->img_account;
                            }else{
                                $img_notification = asset('img/img-account.png');
                            }
                        @endphp

                        <div class="col-1 img-account-likes img-account-search" style="background-image: url('{{$img_notification}}')!important">
                        </div>

                        <div class="col-6">
                            <h5 class="name-likes">
                                <a class="name-likes"  href="/{{$user_like->name}}">{{$user_like->name}}</a>
                            </h5>
                            <p>{{"@" . $user_like->user_name}}</p>
                        </div>
                        <div class="col" style="padding: 0!important">
                            @if(auth()->check() && auth()->user()->id != $user_like->id)
                                {{-- Seguir --}}
                                @php
                                    $is_following = $user_controller->is_following($user_like->id);// Verifica se usuario logado está seguindo usuário da conta
                                @endphp
                                @if(auth()->check() && auth()->user()->email_verified_at) {{-- só usuario com email verificado realiza ação --}}
                                    @if($is_following)
                                        <a href="" class="btn btn-blue btn-sm follow-user follow-user-{{$user_like->id}}" data-user="{{$user_like->id}}" style="width: 100%; background: #979797!important;">
                                            Deixar de Seguir
                                        </a>
                                    @else
                                        <a href="" class="btn btn-blue btn-sm follow-user follow-user-{{$user_like->id}}" data-user="{{$user_like->id}}" style="width: 100%;">
                                            Seguir
                                        </a>
                                    @endif
                                @else
                                    @if($is_following)
                                        <a href="" data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="btn btn-blue btn-sm follow-user follow-user-{{$user_like->id}}" data-user="{{$user_like->id}}" style="width: 100%; background: #979797!important;">
                                            Deixar de Seguir
                                        </a>
                                    @else
                                        <a href="" data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="btn btn-blue btn-sm follow-user follow-user-{{$user_like->id}}" data-user="{{$user_like->id}}" style="width: 100%;">
                                            Seguir
                                        </a>
                                    @endif
                                @endif

                            @else
                                <a href="/login" class="btn btn-blue btn-sm" style="width: 100%;">
                                    Seguir
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="none-mobile modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
