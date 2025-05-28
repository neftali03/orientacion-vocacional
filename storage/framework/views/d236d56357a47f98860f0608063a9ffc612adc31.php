<?php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Resultados';
?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column gap-1">
    <h3 class="fw-bold text-danger-emphasis mb-0">Resultados</h3>
    <p class="mb-0">
        Muy bien, aspirante. Las carreras que más se aplican a tus aptitudes e intereses son las siguientes:
    </p>
</div>
<div>
    <ul class="list-group mt-4">
        <?php $__currentLoopData = $puntajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $puntaje): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo e($categoria); ?>

                <p class="mb-0"><?php echo e($puntaje); ?></p>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/saludo.blade.php ENDPATH**/ ?>