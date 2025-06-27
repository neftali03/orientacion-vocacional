<div id="sidebar" class="collapse collapse-horizontal show">
    <div class="accordion accordion-flush dx-w-sidebar-md" id="sidebar-nav">
        {{-- TCA-FEPADE --}}
        <div class="accordion-item">
            <div class="accordion-header">
                <button class="accordion-button collapsed py-2" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        aria-expanded="false"
                        data-bs-target="#collapse-itca"
                        aria-controls="collapse-itca">
                        ITCA-FEPADE
                </button>
            </div>
            <div id="collapse-itca" 
                 class="accordion-collapse collapse"
                 data-bs-parent="#sidebar-nav">
                <div class="accordion-body bg-body py-0 px-0">
                    <div class="list-group list-group-flush w-100">
                        <a href="{{ route('degree') }}" class="list-group-item list-group-item-action">✓ Carreras</a>
                        <a href="{{ route('institution') }}" class="list-group-item list-group-item-action">✓ Institución</a>
                        <a href="{{ route('questions') }}" class="list-group-item list-group-item-action">✓ Preguntas frecuentes</a>
                    </div>
                </div>
            </div>
        </div>
        @if (session('hasura_user_role') === 'admin')
            {{-- Administrador --}}
            <div class="accordion-item">
                <div class="accordion-header">
                    <button class="accordion-button collapsed py-2" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            aria-expanded="false"
                            data-bs-target="#collapse-admin"
                            aria-controls="collapse-admin">
                            ADMINISTRADOR
                    </button>
                </div>
                <div id="collapse-admin" 
                    class="accordion-collapse collapse"
                    data-bs-parent="#sidebar-nav">
                    <div class="accordion-body bg-body py-0 px-0">
                        <div class="list-group list-group-flush w-100">
                            <a href="{{ route('degree.list') }}" class="list-group-item list-group-item-action">✓ Carreras</a>
                            <a href="{{ route('institution.list') }}" class="list-group-item list-group-item-action">✓ Escuelas</a>
                            <a href="{{ route('questions.list') }}" class="list-group-item list-group-item-action">✓ Preguntas test</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif    
    </div>
</div>
