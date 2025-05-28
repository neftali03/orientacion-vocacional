<div class="modal fade" id="<?php echo e($id ?? 'customModal'); ?>" tabindex="-1" aria-labelledby="<?php echo e($id ?? 'customModal'); ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 fw-bold text-start" id="<?php echo e($id ?? 'customModal'); ?>Label">
                    <?php echo e($title ?? 'Título'); ?>

                </h5>
            </div>
            <div class="modal-body fs-5 justify-content-center">
                <?php echo $message ?? 'Contenido...'; ?>

            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-primary px-4 fw-bold" data-bs-dismiss="modal"  onclick="<?php echo e($id === 'completionModal' ? 'handleFinalAccept()' : ''); ?>">
                    <?php echo e($buttonText ?? 'Nombre'); ?>

                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/components/modal.blade.php ENDPATH**/ ?>