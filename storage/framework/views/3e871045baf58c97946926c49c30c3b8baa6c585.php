<?php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Evaluación';
?>

<?php $__env->startSection('content'); ?>
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
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'welcomeModal','title' => 'Información','message' => 
            '
                A continuación, se te harán una serie de preguntas en las que deberás responder con <strong>Sí</strong> o <strong>No</strong>.<br>¡Suerte!
            '
        ,'buttonText' => 'Aceptar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'welcomeModal','title' => 'Información','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
            '
                A continuación, se te harán una serie de preguntas en las que deberás responder con <strong>Sí</strong> o <strong>No</strong>.<br>¡Suerte!
            '
        ),'buttonText' => 'Aceptar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'completionModal','title' => 'Información','message' => 
            '
                <strong>¡Enhorabuena!</strong> Has terminado tu test.
            '
        ,'buttonText' => 'Aceptar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'completionModal','title' => 'Información','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(
            '
                <strong>¡Enhorabuena!</strong> Has terminado tu test.
            '
        ),'buttonText' => 'Aceptar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <script>
        let questions = <?php echo json_encode($questions, 15, 512) ?>;
        let currentQuestionIndex = 0;

        function showQuestion() {
            const questionText = document.getElementById('question-text');
            questionText.textContent = ''; // Limpia texto anterior

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
                }, 15); // velocidad ajustable

            } else {
                document.getElementById('question-container').style.display = 'none';

                // Mostrar modal de finalización
                const completionModal = new bootstrap.Modal(document.getElementById('completionModal'));
                completionModal.show();
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

            fetch('<?php echo e(route("test.save")); ?>', {
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

        showQuestion();
        function handleFinalAccept() {
            const userId = '00000000-0000-0000-0000-000000000001'; // ID quemado por ahora

            fetch('/enviar-user-id', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    userId: userId
                })
            })
            .then(res => res.text()) // Laravel devuelve una vista HTML
            .then(html => {
                const newWindow = window.open('', '_blank'); // Puedes cambiar a "_self" si no quieres nueva pestaña
                newWindow.document.write(html);
                newWindow.document.close();
            })
            .catch(error => {
                console.error('Error al enviar a Rasa:', error);
                alert('No se pudo enviar el saludo.');
            });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/test/test.blade.php ENDPATH**/ ?>