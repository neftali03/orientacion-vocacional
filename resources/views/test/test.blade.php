@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'ITCA-FEPADE', 'url' => route('index')],
    ];
    $pageTitle = 'Evaluación';
@endphp

@section('content')
    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">Evaluación vocacional</h3>
    </div>

    <div class="container py-5 d-flex flex-column" style="height: 80vh;">
        <!-- Chat Scrollable -->
        <div id="chat-history" class="flex-grow-1 overflow-auto d-flex flex-column gap-3 py-4" style="scroll-behavior: smooth;">
        </div>
        <!-- Pregunta y botones abajo -->
        <div id="question-container" class="d-flex flex-column gap-3 justify-content-center pt-3 border-top">
            <div class="p-3 rounded shadow-sm d-inline-block text-bot align-self-start">
                <p id="question-text" class="mb-0 fw-bold">Cargando...</p>
            </div>
            <div class="d-flex justify-content-center gap-4 mt-3">
                <button onclick="answer(true)" class="btn btn-orange btn-lg px-5 py-3 fw-bold">Sí</button>
                <button onclick="answer(false)" class="btn btn-yellow btn-lg px-5 py-3 fw-bold">No</button>
            </div>
        </div>
    </div>
    <div id="custom-loading-toast" class="toast-container position-fixed bottom-0 end-0 p-3 d-none" style="z-index: 1100;">
        <div id="toast-inner" class="toast text-white" style="background-color: #8B5CF6;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-white" style="background-color: #7C3AED;">
                <div class="bg-white rounded p-1 me-2 d-flex align-items-center" style="width: 32px; height: 32px;">
                    <!-- Ícono Robot Cargando -->
                    <svg viewBox="0 0 64 64" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="20" width="44" height="32" rx="8" fill="#EDE9FE"/>
                        <circle cx="22" cy="36" r="4" fill="#8B5CF6"/>
                        <circle cx="42" cy="36" r="4" fill="#8B5CF6"/>
                        <path d="M28 44h8" stroke="#6D28D9" stroke-width="2" stroke-linecap="round"/>
                        <path d="M32 10v10" stroke="#4B5563" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <strong class="me-auto">Cargando</strong>
            </div>
            <div class="toast-body">
                <div class="spinner-border spinner-border-sm text-light me-2" role="status"></div>
                <span>Espere por favor...</span>
            </div>
        </div>
    </div>
    @push('modals')
        <x-modal 
            id="welcomeModal"
            title="Información"
            :message="
                '
                    A continuación, se te harán una serie de preguntas en las que deberás responder con <strong>Sí</strong> o <strong>No</strong>.<br>¡Suerte!
                '
            "
            buttonText="Aceptar" 
        />
        <x-modal 
            id="completionModal"
            title="Información"
            :message="
                '
                    <strong>¡Enhorabuena!</strong> Has completado tu evaluación de orientación vocacional.
                '
            "
            buttonText="Aceptar" 
        />
    @endpush

    <script>
        let questions = @json($questions);
        let currentQuestionIndex = 0;

        function showQuestion() {
            const questionText = document.getElementById('question-text');
            questionText.textContent = '';

            if (currentQuestionIndex < questions.length) {
                const q = questions[currentQuestionIndex];
                let index = 0;

                const typeWriter = setInterval(() => {
                    if (index < q.description.length) {
                        questionText.textContent += q.description.charAt(index);
                        index++;
                    } else {
                        clearInterval(typeWriter);
                    }
                }, 15);

            } else {
                document.getElementById('question-container').style.display = 'none';
                const completionModal = new bootstrap.Modal(document.getElementById('completionModal'));
                completionModal.show();
                desactivarEncuesta();
            }
        }

        function answer(selection) {
            const question = questions[currentQuestionIndex];
            const chatHistory = document.getElementById('chat-history');

            // Bot (pregunta)
            const botMsg = document.createElement('div');
            botMsg.className = 'p-3 rounded shadow-sm d-inline-block text-bot align-self-start';
            botMsg.innerHTML = `<p class="mb-0 fw-bold">${question.description}</p>`;
            chatHistory.appendChild(botMsg);

           // Usuario (respuesta)
            const userMsg = document.createElement('div');
            userMsg.className = `p-3 rounded shadow-sm d-inline-block text-user align-self-end ${
                selection ? 'btn btn-orange btn-lg px-5 py-3 fw-bold' : 'btn btn-yellow btn-lg px-5 py-3 fw-bold'
            }`;
            userMsg.innerHTML = `<p class="mb-0">${selection ? 'Sí' : 'No'}</p>`;
            chatHistory.appendChild(userMsg);
            
            chatHistory.scrollTop = chatHistory.scrollHeight;

            fetch('{{ route("test.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    question_id: question.id,
                    selection: selection
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    currentQuestionIndex++;
                    showQuestion();
                } else {
                    alert('Error al guardar respuesta.');
                    console.error(data.errors);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Error de conexión al servidor.');
            });
        }

        function desactivarEncuesta() {
            fetch("{{ route('user-survey.deactivate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Encuesta desactivada correctamente.");
                } else {
                    console.error("Error al desactivar encuesta:", data.error);
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });
        }

        // Al cargar
        document.addEventListener('DOMContentLoaded', showQuestion);
        document.addEventListener('DOMContentLoaded', () => {
            const completionModal = document.getElementById('completionModal');
            const loadingToast = document.getElementById('custom-loading-toast');
            const toastInner = document.getElementById('toast-inner');

            completionModal.addEventListener('hidden.bs.modal', () => {
                // Mostrar mensaje de carga con toast de Bootstrap
                const toast = new bootstrap.Toast(toastInner, { autohide: false });
                loadingToast.classList.remove('d-none');
                toast.show();

                // Redirigir luego de un breve delay
                setTimeout(() => {
                    window.location.href = "{{ route('deepseek.result') }}";
                }, 300);
            });
        });
    </script>

@endsection
