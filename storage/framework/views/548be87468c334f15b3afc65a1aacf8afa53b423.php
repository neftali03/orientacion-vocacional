<?php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Preguntas';
?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column gap-1">
    <h3 class="fw-bold text-danger-emphasis mb-0">Preguntas Frecuentes</h3>
    <p class="mb-0">
      Bienvenido a la sección de preguntas frecuentes. Si no encuentras lo que buscas,
      puedes escribirnos al correo <strong>correoAdmin@itca.edu.sv</strong> y con gusto te atenderemos.
    </p>
</div>
<div class="accordion accordion-flush py-5" id="accordionFlushExample">
    <?php $__currentLoopData = $questions_answer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $questions_answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading<?php echo e($index); ?>">
                <button class="accordion-button collapsed fw-bold" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse<?php echo e($index); ?>"
                        aria-expanded="false"
                        aria-controls="flush-collapse<?php echo e($index); ?>">
                    <?php echo e($questions_answer['question']); ?>

                </button>
            </h2>
            <div id="flush-collapse<?php echo e($index); ?>"
                 class="accordion-collapse collapse"
                 aria-labelledby="flush-heading<?php echo e($index); ?>"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <?php echo e($questions_answer['answer']); ?>

                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/questions/questions.blade.php ENDPATH**/ ?>