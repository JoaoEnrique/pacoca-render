<div class="modal fade" id="modal-edit-post-{{$post->id}}" tabindex="-1" aria-labelledby="modal-edit-post-{{$post->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/edit-post" class="form-edit-post form-edit-post-{{$post->id}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-post">Editar Publicação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_post" value="{{$post->id}}">
                    <textarea class="form-control text-comment mb-2" type="text" name="text_update" placeholder="Adicionar publicação" required>{{$post->text}}</textarea>
                    @if($post->img)
                        <img src="{{$post->img}}" alt="" style="width: 100%">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-blue" data-bs-dismiss="modal">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
