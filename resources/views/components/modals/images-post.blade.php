<div class="modal modal-fundo-black fade modal-view-img" id="modal-img-{{$images_post[0]->id}}" tabindex="-1" aria-labelledby="modal-img-{{$images_post[0]->id}}" aria-hidden="true">
    <button class="button-x-modal" type="button" data-bs-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
    </button>

    <div class="modal-dialog modal-dialog-grande" style="max-width: fit-content;margin: 0 auto!important; justify-content: center;
    align-items: center;
    display: flex;">
        <div class="modal-content modal-content-grande" style="background: transparent !important;border: 0 !important;">
            <div class="modal-body modal-body-grande" style="display: flex;justify-content: center;">
                @php
                    //verificar se img existe
                    $path = $images_post[0]->path;
                    $path = str_replace('public/', '', $images_post[0]->path);

                    if (file_exists($path)) {
                        $path_img = asset($path);
                    } else {
                        $path_img = asset('img/image_not_found.png');
                    }
                @endphp
                <img style="min-width: auto; max-width: fit-content;"  src="{{$path_img}}" id="img-post" class="img-post" srcset="">

                    <script>
                        function verificarOrientacaoImagem(urlDaImagem) {
                            var img = new Image();
                            img.onload = function() {
                                var largura = this.width;
                                var altura = this.height;
                                var elementoImg = document.getElementById('img-post');

                                if (largura > altura) {
                                    // console.log("Imagem está na orientação paisagem (deitada).");
                                    // elementoImg.style.width = "1000px";
                                } else if (largura < altura) {
                                    // console.log("Imagem está na orientação retrato (em pé).");
                                    elementoImg.style.maxWidth = "fit-content";
                                    // elementoImg.style.minWidth = "fit-content";
                                } else {
                                    // console.log("Imagem está na orientação quadrada.");
                                }
                            };
                            img.src = urlDaImagem;
                        }

                        // Exemplo de uso
                        verificarOrientacaoImagem("{{$path_img}}");
                    </script>

            </div>
        </div>
    </div>
</div>
