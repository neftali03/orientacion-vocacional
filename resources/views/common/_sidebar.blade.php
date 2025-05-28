<div id="sidebar" class="collapse collapse-horizontal show">
    <div class="accordion accordion-flush dx-w-sidebar-md" id="sidebar-nav">
        <div class="accordion-item">
            <div class="accordion-header">
                <button class="accordion-button collapsed py-2" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        aria-expanded="false"
                        data-bs-target="#collapse"
                        aria-controls="collapse">
                        ITCA-FEPADE
                </button>
            </div>
            <div id="collapse" 
                 class="accordion-collapse collapse"
                 data-bs-parent="sidebar-nav">
                <div class="accordion-body bg-body py-0 px-0">
                    <div class="list-group list-group-flush w-100">
                        <a href="{{ route('institution') }}" class="list-group-item list-group-item-action">✓ Institución</a>
                        <a href="{{ route('degree') }}" class="list-group-item list-group-item-action">✓ Carreras</a>
                        <a href="{{ route('questions') }}" class="list-group-item list-group-item-action">✓ Preguntas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
