<ol class="breadcrumb m-0">
    <?php if(!empty($firstItem)): ?>
        <li class="breadcrumb-item active fw-bold" aria-current="page"><?php echo e($firstItem); ?></li>
    <?php endif; ?>

    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="breadcrumb-item" aria-current="page">
            <?php if(!empty($breadcrumb['url'])): ?>
                <a href="<?php echo e($breadcrumb['url']); ?>" class="link-light"><?php echo e($breadcrumb['title']); ?></a>
            <?php else: ?>
                <?php echo e($breadcrumb['title']); ?>

            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(!empty($lastItem)): ?>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e($lastItem); ?></li>
    <?php endif; ?>
</ol>

<?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/components/breadcrumb.blade.php ENDPATH**/ ?>