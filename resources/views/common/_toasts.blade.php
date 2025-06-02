<div class="position-fixed top-0 start-0 p-3" style="z-index: 1100; max-width: 400px;">
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <div class="bg-white rounded p-1 me-2 d-flex align-items-center" style="width: 32px; height: 32px;">
                        <!-- Ícono Robot Éxito -->
                        <svg viewBox="0 0 64 64" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="20" width="44" height="32" rx="8" fill="#D1FAE5"/>
                            <circle cx="22" cy="36" r="4" fill="#10B981"/>
                            <circle cx="42" cy="36" r="4" fill="#10B981"/>
                            <path d="M24 44c2 2 6 2 8 0" stroke="#059669" stroke-width="2" stroke-linecap="round"/>
                            <path d="M32 10v10" stroke="#4B5563" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <strong class="me-auto">Orientación vocacional</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <div class="bg-white rounded p-1 me-2 d-flex align-items-center" style="width: 32px; height: 32px;">
                        <!-- Ícono Robot Error -->
                        <svg viewBox="0 0 64 64" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="20" width="44" height="32" rx="8" fill="#FEE2E2"/>
                            <circle cx="22" cy="36" r="4" fill="#EF4444"/>
                            <circle cx="42" cy="36" r="4" fill="#EF4444"/>
                            <path d="M24 44c2 -2 6 -2 8 0" stroke="#B91C1C" stroke-width="2" stroke-linecap="round"/>
                            <path d="M32 10v10" stroke="#4B5563" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <strong class="me-auto">Orientación vocacional</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show text-white" style="background-color:rgb(96, 124, 250);" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-white" style="background-color:rgb(96, 106, 250);">
                    <div class="bg-white rounded p-1 me-2 d-flex align-items-center" style="width: 32px; height: 32px;">
                        <!-- Ícono Robot Info -->
                        <svg viewBox="0 0 64 64" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="20" width="44" height="32" rx="8" fill="#DBEAFE"/>
                            <circle cx="22" cy="36" r="4" fill="#3B82F6"/>
                            <circle cx="42" cy="36" r="4" fill="#3B82F6"/>
                            <path d="M28 44h8" stroke="#1D4ED8" stroke-width="2" stroke-linecap="round"/>
                            <path d="M32 10v10" stroke="#4B5563" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <strong class="me-auto">Orientación vocacional</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
                <div class="toast-body">
                    {{ session('info') }}
                </div>
            </div>
        </div>
    @endif
</div>