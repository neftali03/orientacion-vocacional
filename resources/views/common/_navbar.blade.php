<nav class="navbar navbar-expand-lg dx-bg-navbar py-1">
  <div class="container-fluid">
    <div class="d-flex flex-row dx-w-navbar fw-bold">
      <button type="button"
              class="btn border-0 text-white"
              data-bs-toggle="collapse"
              data-bs-target="#sidebar"
              aria-expanded="true"
              aria-controls="sidebar">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand ms-2 text-white fs-6" href="{{ route('index') }}">
        Orientación vocacional
      </a>
    </div>
    <div class="text-white px-5 py-1 ms-4 d-none d-lg-block">
      <x-breadcrumb :breadcrumbs="$breadcrumbs ?? []" :page-title="$pageTitle ?? ''" />
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
          {{ $hasuraUserFirstName ?? 'Invitado' }}
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
