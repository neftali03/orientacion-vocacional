<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Orientación vocacional</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    <script src="<?php echo e(asset('js/bootstrap/bootstrap.bundle.js')); ?>" defer></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body hx-ext="loading-states">
    <?php echo $__env->make('common._navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-auto px-0 border-end">
                <?php echo $__env->make('common._sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <main class="col px-3 py-3 py-md-2">
                <h5 class="fw-bold mt-2 mb-4 text-primary-emphasis"></h5>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <script src="<?php echo e(asset('js/base.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/layouts/base.blade.php ENDPATH**/ ?>