<div class="modal fade modal-comment" id="modal-comentarios-{{$post->id}}" tabindex="-1" aria-labelledby="modal-comentarios-{{$post->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-comentarios-{{$post->id}}">Comentários</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-body-{{$post->id}}" style="overflow: auto; max-height: 70vh; min-height: 70vh;">
            {{-- Comentarios --}}
            @foreach ($users_comment as $user_comment)
                @if($user_comment->id_post == $post->id)
                    <div class="row card-comment-{{$user_comment->id}}" style="margin-top:10px">

                        {{-- Imagem da conta no post --}}
                        @php
                            if($user_comment->img_account){
                                $img_notification = $user_comment->img_account;
                            }else{
                                $img_notification = asset('img/img-account.png');
                            }
                        @endphp

                        <div class="col-1 img-account-likes img-account-search" style="background-image: url('{{$img_notification}}')!important">
                        </div>
                        <div class="col">
                            <div class="comment-text">

                                {{-- btn Configuração --}}
                               {{-- Caso o comentario seja do usuario logado --}}
                               @if(auth()->check() && auth()->user()->id == $user_comment->id_user)
                                   <div class="col-1 col-conf-post" style="right: 10px!important; position: absolute; background: transparent">
                                       <div class="dropdown">
                                           <button style="border: 0; border-radius: 5px" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                   <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                               </svg>
                                           </button>
                                           <ul class="dropdown-menu">
                                               {{-- <li><a type="button" data-bs-toggle="modal" data-bs-target="#modal-edit-comment-{{$user_comment->id}}" class="dropdown-item" href="#">Editar</a></li> --}}
                                               <li><a class="dropdown-item delete-comment" data-comment="{{$user_comment->id}}" data-post="{{$post->id}}" href="">Excluir</a></li>
                                           </ul>
                                       </div>
                                   </div>
                               @endif

                               @php
                                    $padrao_link = '/(https?:\/\/[^\s]+)/';
                                    $padrao_tag_user = '/(@[^\s]+)/';

                                    // Formata como link se houver um link
                                    $texto_formatado_comment = preg_replace_callback($padrao_link, function ($match) {
                                        $url = $match[0];
                                        return "<a href='$url' target='_blank' style='word-wrap: break-word;'>$url</a>";
                                    }, $user_comment->text);

                                    // Link caso o usuário mencione outro
                                    $texto_formatado_comment = preg_replace_callback($padrao_tag_user, function ($match) {
                                        $username = substr($match[0], 1); // Remove o "@" do início do username

                                        // Verifica se existe um usuário com esse nome de usuário
                                        $user_controller = app(App\Http\Controllers\UserController::class);
                                        $user = $user_controller->getUserByUserName($username);

                                        if ($user) {
                                            return "<a href='/$username' style='word-wrap: break-word;'>$match[0]</a>";
                                        } else {
                                            // Se o usuário não existir, exibe apenas o texto sem formatação
                                            return $match[0];
                                        }
                                    }, $texto_formatado_comment); // Use $texto_formatado em vez de $post->text
                                @endphp

                                <h1 style="font-size: 17px;">{{$user_comment->name}} </h1> &nbsp;
                                <p class="date-comment"> - {{$user_controller->dateDifference($user_comment->created_at)}}</p>
                                <p class="text-comment text-comment-{{$user_comment->id}}">
                                    {!! nl2br($texto_formatado_comment) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="modal-footer">
            @if(auth()->user())
                @if(auth()->user()->email_verified_at) {{-- só usuario com email verificado realiza ação --}}
                    <div class="row row-comment" id="row-comment-{{$post->id}}" style="margin-top: 20px; width: 100%">
                        <div class="col">
                            <form class="form-comment" method="POST" action="/comment" data-id-post="{{$post->id}}">
                                @csrf
                                <input type="hidden" name="id_post" value="{{$post->id}}">
                                <input type="hidden" name="name" value="{{auth()->user()->name}}">
                                <input type="hidden" name="img_account" value="{{auth()->user()->img_account}}">
                                <textarea class="form-control text-comment me-2" type="text" name="comment" placeholder="Adicionar comentário" required></textarea>
                                <button class="btn btn-blue button-submit-comment" type="submit" style="height: 40px;  margin-top: 10px">Comentar </button>
                            </form>
                        </div>
                    </div>
                    @else
                        <div class="row row-comment" id="row-comment-{{$post->id}}" style="margin-top: 20px; width: 100%">
                            <p>Para comentar, você precisa verificar seu email.</p>

                            <button type="submit" class="btn btn-blue">Verificar email</button>
                        </div>
                    @endif
            @endif
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> --}}
        </div>
        </div>
    </div>
</div>
