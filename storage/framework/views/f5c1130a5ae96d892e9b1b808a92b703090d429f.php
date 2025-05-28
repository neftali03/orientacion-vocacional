<nav class="navbar navbar-expand-lg dx-bg-navbar py-1">
  <div class="container-fluid ps-0">
    <div class="d-flex flex-row dx-w-navbar fw-bold">
      <button type="button"
              class="btn border-0 text-white"
              data-bs-toggle="collapse"
              data-bs-target="#sidebar"
              aria-expanded="false"
              aria-controls="sidebar">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand ms-2 text-white" href="<?php echo e(route('index')); ?>">
        O.V.
      </a>
    </div>
    <div class="text-white px-3 py-2">
      <?php if (isset($component)) { $__componentOriginal40fe594eae3d7d27fa8bd9a508c1498f43cae280 = $component; } ?>
<?php $component = App\View\Components\Breadcrumb::resolve(['breadcrumbs' => $breadcrumbs ?? [],'pageTitle' => $pageTitle ?? ''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Breadcrumb::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40fe594eae3d7d27fa8bd9a508c1498f43cae280)): ?>
<?php $component = $__componentOriginal40fe594eae3d7d27fa8bd9a508c1498f43cae280; ?>
<?php unset($__componentOriginal40fe594eae3d7d27fa8bd9a508c1498f43cae280); ?>
<?php endif; ?>
    </div>
    <div class="d-flex align-items-center ms-auto">
      <button id="toggle-color-mode" class="btn text-white btn-sm me-2">
        <i class="bi bi-moon-fill"></i>
      </button>
    </div>
    <div class="dropdown me-2">
      <button class="btn text-white btn-sm dropdown-toggle py-1 border-0"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
          <?php echo e($hasuraUserFirstName ?? 'Invitado'); ?>

      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php /**PATH /home/neftali/Source/orientacion-vocacional/resources/views/common/_navbar.blade.php ENDPATH**/ ?>