<?php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Instituciones';
?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">¿Quiénes somos?</h3>
        <p class="mb-0">
        Description.
        </p>
    </div>

    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">Contacto</h3>
        <p class="mb-0">
        Description.
        </p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/institution/institution.blade.php ENDPATH**/ ?>