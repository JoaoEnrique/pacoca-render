
@php
    $post_controller = app(App\Http\Controllers\PostsController::class);
    $user_controller = app(App\Http\Controllers\UserController::class);
@endphp

{{-- Lista todos os posts --}}
@foreach ($posts as $post)

    {{-- Informações do post --}}
    @php
        $datePost = $post_controller->getDatePost($post); //tempo de postagem
        $followers = $user_controller->getFollowers($post->id_user); //tempo de postagem
        $edit = $post_controller->isPostEdit($post); //se foi editado
        $like = $post_controller->liked_post($post); //se o usuario logado curtiu
        $users_like = $post_controller->users_like($post->id); //todos os usuários que curtiram o post
        $users_comment = $post_controller->users_comment($post); //todos os usuários que comentaram o post
        $comments = $post_controller->comments_post($post); //se o usuario acabou de comentar post
        $images_post = $post_controller->getImagesPost($post->id);
    @endphp

<div class="card card-post card-post-{{$post->id}}">
    <div class="row">
        {{-- Imagem da conta no post --}}
        @php
            if($post->img_account){
                $img_account = $post->img_account;
            }else{
                $img_account = asset('img/img-account.png');
            }
        @endphp

        <div class="col-2 img-list-chat img-account-search" style="background-image: url('{{$img_account}}')!important">
        </div>

        <div class="col col-post">
            <h2>
                <a href="/{{$post->user_name}}">{{$post->name}}</a> {{-- Nome --}}
                    {{-- IMAGEM DE VERIFICADO --}}
                    @if ($post->user_name == 'joao' || $post->user_name == 'pacoca')
                        <img class="img-verificado-comentario" src="{{asset('img/verificado.png?v=1')}} alt=" srcset="">
                    @endif
                </h2>
            <p class="seguidor-post">{{"@".$post->user_name}} - {{count($followers)}} seguidores</p>{{-- Seguidores --}}

            {{-- Data da potagem --}}
            <p>{{$datePost }} {{$edit}}</p>
        </div>
        {{-- btn Configuração --}}
        {{-- Caso o post seja do usuario logado --}}
        @if(auth()->check() && auth()->user()->id == $post->id_user)
            <div class="col-1 col-conf-post">
                <div class="dropdown">
                    <button style="border: 0; border-radius: 5px" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        @if(auth()->check() && auth()->user()->email_verified_at) {{-- só usuario com email verificado realiza ação --}}
                            <li><a type="button" data-bs-toggle="modal" data-bs-target="#modal-edit-post-{{$post->id}}" class="dropdown-item" href="#">Editar</a></li>
                            <li><a class="dropdown-item delete-post" data-post="{{$post->id}}" href="">Excluir</a></li>
                        @else
                            <li><a type="button" data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="dropdown-item" href="#">Editar</a></li>
                            <li><a  data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="dropdown-item" href="">Excluir</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
    </div>

    {{-- Texto da postagem --}}
    <div class="row row-text-post">
        @php
            $padrao_link = '/(https?:\/\/[^\s]+)/';
            $padrao_tag_user = '/(@[^\s]+)/';

            // Formata como link se houver um link
            $texto_formatado = preg_replace_callback($padrao_link, function ($match) {
                $url = $match[0];
                return "<a href='$url' target='_blank' style='word-wrap: break-word;'>$url</a>";
            }, $post->text);

            // Link caso o usuário mencione outro
            $texto_formatado = preg_replace_callback($padrao_tag_user, function ($match) {
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
            }, $texto_formatado); // Use $texto_formatado em vez de $post->text
        @endphp

        <p class="text-post"><div id="text-post-{{$post->id}}">{!! nl2br($texto_formatado) !!}</div></p>
    </div>

    {{-- Caso o post tenha imagem --}}

        @if($images_post && count($images_post) == 1) {{-- CASO TENHA SÓ UMA IMAGEM --}}
            @if ($images_post[0]->type == 0) {{-- CASO SEJA UMA IMAGEM --}}
                @php
                    $path = str_replace('public/', '', $images_post[0]->path);

                    if (file_exists($path)) {
                        $path_img = asset($path);
                    } else {
                        $path_img = asset('img/image_not_found.png');
                    }
                @endphp

                <div class="row row-img-post">
                    <div class="col col-img-post" >

                        <p type="button" style="margin: 2px 0;" data-bs-toggle="modal" data-bs-target="#modal-img-{{$images_post[0]->id}}">


                            <img src="{{$path_img}}?v=2" class="img-post" id="img-post-resize-{{$path_img}}" srcset="" style=" @php  if(file_exists($path)){ echo "z-index: -10"; } @endphp">

                            <script>
                                function verificarOrientacaoImagem(urlDaImagem) {
                                    var img = new Image();
                                    img.onload = function() {
                                        var largura = this.width;
                                        var altura = this.height;
                                        var elementoImg = document.getElementById('img-post-resize-{{$path_img}}');

                                        if (largura > altura) {
                                            // console.log("Imagem está na orientação paisagem (deitada).");
                                            // elementoImg.style.width = "1000px";
                                        } else if (largura < altura) {
                                            // console.log("Imagem está na orientação retrato (em pé).");
                                            elementoImg.style.maxWidth = "85%";
                                            elementoImg.style.minWidth = "85%";
                                        } else {
                                            // console.log("Imagem está na orientação quadrada.");
                                        }
                                    };
                                    img.src = urlDaImagem;
                                }

                                // Exemplo de uso
                                verificarOrientacaoImagem("{{$path_img}}");
                            </script>
                        </p>

                        <!-- MODAL DE IMAGENS -->
                        @include('components.modals.images-post')
                    </div>
                </div>
            @else {{-- CASO SEJA UM VIDEO --}}
                <div class="row row-img-post">
                    <div class="col col-img-post" data-img="{{$images_post[0]->path}}">
                        <video controls src="{{$images_post[0]->path}}" class="img-post" srcset="" style="width: 100%;height: 100%;"></video>
                    </div>
                </div>

            @endif

        {{-- CASO TENHA UMA IMAGEM E UM VIDEO --}}
        @else
            @if($images_post != '[]')
                <div class="row row-img-post">
                    <div class="col col-img-post" style="display: flex; overflow: auto">
                        @foreach ($images_post as $image_post)
                            {{-- CASO SEJA UM VÍDEO --}}
                            @if($image_post->type)
                                <video  controls="controls" class="img-post" srcset="" style="margin: 0 5px;">
                                    <source src="{{$image_post->path}}" type="video/mp4">
                                </video>
                            {{-- CASO SEJA UMA IMAGEN --}}
                            @else
                                <img src="{{$image_post->path}}" class="img-post" srcset="" style="margin: 0 5px;">
                            @endif
                            @endforeach
                    </div>
                </div>
            @endif
        @endif


    {{-- Informações post --}}
    <div class="row row-info-post">
        <div class="col col-like" data-bs-toggle="modal" data-bs-target="#modal-curtida-{{$post->id}}">
            <p type="button" style="margin: 0; text-align: center!important">
                {{-- Numero de curtidas --}}
                <span id="curtida-{{$post->id}}">{{ count($users_like) }}</span></span>
                <span>curtidas</span>
            </p>
        </div>
        <div class="col col-comment" style="text-align: center" data-bs-toggle="modal" data-bs-target="#modal-comentarios-{{$post->id}}">
            <p type="button" style="margin: 2px 0;">
                {{-- Numero de comentarios --}}
                <span id="comentarios-{{$post->id}}">{{ count($comments) }}</span></span>
                <span>comentários</span>
            </p>
        </div>
        <div class="col col-comment" style="text-align: end" id="btnCopiar-1-{{$post->id}}">
            <p type="button" style="margin: 2px 0;">
                <span>compartilhar</span>
            </p>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                // Adiciona um evento de clique ao botão
                document.getElementById("btnCopiar-1-{{$post->id}}").addEventListener("click", function() {
                    // Seleciona o texto da área de texto
                    var texto = document.getElementById("link_{{$post->id}}");
                    texto.select();
                    texto.setSelectionRange(0, 99999); // Para dispositivos móveis

                    // Tenta copiar o texto para a área de transferência
                    try {
                        document.execCommand("copy");
                        // document.querySelector(".compartilhar-post").innerHTML = "Link Copiado"
                        alert("Link copiado, agora você pode compartilhar para quem quiser");
                    } catch (err) {
                        alert("Erro ao copiar texto: " + err);
                        // document.querySelector(".compartilhar-post").innerHTML = "Erro ao copiar link"
                    }
                });
            });
        </script>
        </div>
    </div>

    <div class="row row-reaction-post div-like-{{$post->id}}">

        {{-- verificar se email está verificado --}}
        @php
            if(auth()->check() && auth()->user()->email_verified_at){
                $email_verify = true;
            }else{
                $email_verify = false;
            }
        @endphp

        {{--
            email não verificado retorna modal para verificar email:
            @if(!$email_verify) data-bs-toggle="modal" data-bs-target="#modal-verificar-email" @endif

        --}}

        {{-- Curtir --}}
        {{-- @if(auth()->check()) --}}
            <div @if(!$email_verify) data-bs-toggle="modal" data-bs-target="#modal-verificar-email" @endif @if($email_verify)data-id-post="{{$post->id}}"@endif class="button-like col col-like" @if(!auth()->check()) onclick="window.location.href='/login'" @endif>
                {{-- Caso usuário logado tenha curtido --}}
                @if($like)
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class="icon-reaction-post red" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class="icon-reaction-post" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                @endif
            </div>
        {{-- @endif --}}

        {{-- @else
            <div data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="button-like col col-like" @if(!auth()->check()) onclick="window.location.href='/login'" @endif>
                @if($like)
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class="icon-reaction-post red" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class="icon-reaction-post" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                @endif
            </div>
        @endif --}}

        @if(auth()->check() && auth()->user()->email_verified_at) {{-- só usuario com email verificado realiza ação --}}
            {{-- Comentar --}}
            <div data-id-post="{{$post->id}}" class="button-comment col col-like" @if(!auth()->check()) onclick="window.location.href='/login'" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class=" icon-reaction-post" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </div>
        @else
            {{-- Comentar --}}
            <div  data-bs-toggle="modal" data-bs-target="#modal-verificar-email" class="button-comment col col-like" @if(!auth()->check()) onclick="window.location.href='/login'" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class=" icon-reaction-post" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </div>
        @endif

        {{-- Compartilhar --}}
        <div class="col col-like" id="btnCopiar-{{$post->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" class="icon-reaction-post" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
            </svg>
        </div>

        {{-- link compartilharmento --}}
        <input value="{{url('/')}}/post/{{$post->id}}" type="text" name="link_{{$post->id}}" id="link_{{$post->id}}" style="position: absolute; z-index: -10">

        <script>
                document.addEventListener("DOMContentLoaded", function() {
                // Adiciona um evento de clique ao botão
                document.getElementById("btnCopiar-{{$post->id}}").addEventListener("click", function() {
                    // Seleciona o texto da área de texto
                    var texto = document.getElementById("link_{{$post->id}}");
                    texto.select();
                    texto.setSelectionRange(0, 99999); // Para dispositivos móveis

                    // Tenta copiar o texto para a área de transferência
                    try {
                        document.execCommand("copy");
                        // document.querySelector(".compartilhar-post").innerHTML = "Link Copiado"
                        alert("Link copiado, agora você pode compartilhar para quem quiser");
                    } catch (err) {
                        alert("Erro ao copiar texto: " + err);
                        // document.querySelector(".compartilhar-post").innerHTML = "Erro ao copiar link"
                    }
                });
            });
        </script>
    </div>

    {{-- Ao adicionar comentario mostra ele aqui --}}
    <div class="row row-novo-comentario-{{$post->id}}" style="display:none;margin-bottom: 20px;">
        {{-- Imagem da conta no post --}}
        @php
            if($post->img_account){
                $img_account = $post->img_account;
            }else{
                $img_account = asset('img/img-account.png');
            }
        @endphp
        <div class="col-1 img-account-add-comment" style="background-image: url('{{$img_account}}')!important">
        </div>

        <div class="col" style="">
            <div class="comment-text">
                <p id="text-novo-comentario-{{$post->id}}"></p>
            </div>
        </div>
    </div>

    {{-- Comentar --}}
    @if(auth()->user())
        <div class="row row-comment" id="row-comment-{{$post->id}}" style="display: none; margin-top: 20px;">
            {{-- Imagem da conta no post --}}
            @php
                if($post->img_account){
                    $img_account = $post->img_account;
                }else{
                    $img_account = asset('img/img-account.png');
                }
            @endphp
            <div class="col-1 img-account-add-comment" style="background-image: url('{{$img_account}}')!important">
            </div>

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
    @endif
</div>





    <!-- MODAL DE EDITAR COMENTARIO -->
    @include('components.modals.edit_comment')

    <!-- MODAL DE CURTIDAS -->
    @include('components.modals.likes')

    <!-- MODAL DE COMENTARIOS -->
    @include('components.modals.comments')

    <!-- MODAL DE EDITAR PUBLICAÇÃO -->
    @include('components.modals.edit_post')

@endforeach

<script>
    // Função para verificar a URL e exibir o modal se necessário
    function exibirModalComBaseNaUrl() {
        // Obtém a URL atual
        var urlAtual = window.location.href;

        // Verifica se a URL contém um parâmetro indicando que o modal deve ser exibido
        if (urlAtual.includes('modalComment=true')) {
            // Se sim, mostra o modal
            $('.modal-comment').modal('show');
        }
    }
    // Chama a função ao carregar a página
    window.onload = exibirModalComBaseNaUrl;
</script>




