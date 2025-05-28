<div class="modal fade" id="{{ $id ?? 'customModal' }}" tabindex="-1" aria-labelledby="{{ $id ?? 'customModal' }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 fw-bold text-start" id="{{ $id ?? 'customModal' }}Label">
                    {{ $title ?? 'Título' }}
                </h5>
            </div>
            <div class="modal-body fs-5 justify-content-center">
                {!! $message ?? 'Contenido...' !!}
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-primary px-4 fw-bold" data-bs-dismiss="modal"  onclick="{{ $id === 'completionModal' ? 'handleFinalAccept()' : '' }}">
                    {{ $buttonText ?? 'Nombre' }}
                </button>
            </div>
        </div>
    </div>
</div>