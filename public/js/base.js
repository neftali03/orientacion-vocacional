// noinspection DuplicatedCode,TypeScriptUMDGlobal,JSCheckFunctionSignatures,JSUnresolvedReference



// *********************************************************************
// SIDEBAR
// *********************************************************************

const sidebar = document.body.querySelector('#sidebar');

function updateShowSidebar() {
  let isSidebarSet = localStorage.getItem('showSidebar') !== null;
  let showSidebar = localStorage.getItem('showSidebar') === 'true';
  if (!isSidebarSet) {
    sidebar.classList.add('show');
  } else if (showSidebar) {
    sidebar.classList.add('show');
  } else {
    sidebar.classList.remove('show');
  }
}

updateShowSidebar();

sidebar.addEventListener('hide.bs.collapse', (e) => {
  if (e.target.id === 'sidebar') {
    localStorage.setItem('showSidebar', false);
    updateShowSidebar();
  }
});

sidebar.addEventListener('show.bs.collapse', (e) => {
  if (e.target.id === 'sidebar') {
    localStorage.setItem('showSidebar', true);
    updateShowSidebar();
  }
});

document.addEventListener('keydown', function (event) {
  let key = event.key | event.keyCode;
  if (key === 113) {
    // Key code of F2 key
    const sidebar = document.querySelector('#sidebar');
    const collapseSidebar = new bootstrap.Collapse(sidebar);
    collapseSidebar.toggle();
  }
});



// *********************************************************************
// MESSAGES
// *********************************************************************

// Initialize Toasts
// The `request-message`, intended only for HTMX requests, is not
// handled by instantiating a Toast class, but by adding the class
// `show` during requests using an HTMX extension.
// The `base-message`, as its name implies, will serve as a blueprint
// for another messages, and will be instantiated on a per-case basis.
// The rest of the messages present during the page loading, will be
// instantiated and shown, with the default behaviour (autohide).

const toastElements = document.querySelectorAll(
  '.toast:not(#base-message):not(#request-message)'
);
const toasts = [...toastElements].map(
  (toastEl) => new bootstrap.Toast(toastEl)
);
toasts.map((toastEl) => toastEl.show());

// Show an HTMX message/toast
function showMessage(content, level, _autohide = true) {
  const messages = document.body.querySelector('#messages');
  const message = messages.firstElementChild.cloneNode(true);
  const messageToast = new bootstrap.Toast(message, {autohide: _autohide});

  messages.appendChild(message);
  message.querySelector('#message-body').innerHTML = content;

  // Based on Django's default message levels, excluding DEBUG
  if (level === 20) {
    message.classList.add('bg-info', 'text-bg-info');
  } else if (level === 25) {
    message.classList.add('bg-success', 'text-bg-success');
  } else if (level === 30) {
    message.classList.add('bg-warning', 'text-bg-warning');
  } else if (level === 40) {
    message.classList.add('bg-danger', 'text-bg-danger');
  }

  toasts.push(messageToast);
  messageToast.show();
}

// Show an HTMX message triggered from the back-end
document.body.addEventListener('showHtmxMessage', (evt) => {
  showMessage(evt.detail.content, evt.detail.level);
});

// Handle messages on HTMX response errors
document.body.addEventListener('htmx:beforeSwap', (evt) => {
  if (evt.detail.xhr.status === 422) {
    // Allow 422 responses to swap as we are using this as a signal
    // that a form was submitted with bad data and want to rerender it
    // with the errors
    evt.detail.shouldSwap = true;
    evt.detail.isError = false;
  } else {
    if (evt.detail.xhr.status >= 400 && evt.detail.xhr.status < 600) {
      // In the case of any other error, send a message to the user
      // Not autohide seems more appropriate
      showMessage(
        'Ha ocurrido un error inesperado, por favor contacte al administrador',
        40,
        false
      );
    }
  }
});

// Handle messages on a connection error during an HTMX request
document.body.addEventListener('htmx:sendError', () => {
  // Not autohide seems more appropriate
  let message = '';
  message += 'Ha ocurrido un error de conexión, ';
  message += 'por favor intente nuevamente o contacte al administrador';
  showMessage(message, 40, false);
  // Dismiss non-autohide request message to avoid confusion to the user
  document.body.querySelector('#request-message').classList.remove('show');
});



// *********************************************************************
// FORMS
// *********************************************************************

// Change case of inputs in real time
document.body.querySelectorAll('[dx-case]').forEach((input) => {
  input.addEventListener('input', function (event) {
    let toCase = input.getAttribute('dx-case');
    if (toCase === 'lower') {
      event.target.value = event.target.value.toLowerCase();
    } else if (toCase === 'upper') {
      event.target.value = event.target.value.toUpperCase();
    }
  });
});

// Enforce numeric-only inputs
document.body.querySelectorAll('[dx-numeric]').forEach((input) => {
  input.addEventListener('input', function (event) {
    event.target.value = event.target.value.replace(/\D/g, '');
  });
});

// Enforce alphanumeric-only inputs
document.body.querySelectorAll('[dx-alphanumeric]').forEach((input) => {
  input.addEventListener('input', function (event) {
    event.target.value = event.target.value.replace(/[^a-zA-Z0-9Ññ]/g, '');
  });
});



// *********************************************************************
// WELCOME MODAL ON TEST PAGE
// *********************************************************************

document.addEventListener('DOMContentLoaded', function () {
  const modalElement = document.getElementById('welcomeModal');
  if (modalElement) {
    const modal = new bootstrap.Modal(modalElement, {
      backdrop: 'static',
      keyboard: false
    });
    modal.show();
  }
});



// *********************************************************************
// UTILS
// *********************************************************************

// Close the modal form
document.body.querySelectorAll('#form_modal').forEach((item) => {
  item.addEventListener('closeModalForm', () => {
    let modal = bootstrap.Modal.getInstance(item);
    modal.hide();
  });
});





// *********************************************************************
// TOOLTIPS
// *********************************************************************

// const tooltipTriggerList = document.querySelectorAll(
//   '[data-bs-toggle="tooltip"]'
// );
// const tooltipList = [...tooltipTriggerList].map(
//   (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
// );

// *********************************************************************
// THEME
// *********************************************************************

let colorModeToggler = document.querySelector('#toggle-color-mode');

if (localStorage.getItem('colorTheme') === 'dark') {
  document.documentElement.setAttribute('data-bs-theme', 'dark');
  colorModeToggler.innerHTML = '<i class="bi bi-moon-fill"></i>';
} else {
  document.documentElement.setAttribute('data-bs-theme', 'light');
  colorModeToggler.innerHTML = '<i class="bi bi-brightness-high-fill"></i>';
}
colorModeToggler.addEventListener('click', function () {
  if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
    document.documentElement.setAttribute('data-bs-theme', 'light');
    colorModeToggler.innerHTML = '<i class="bi bi-brightness-high-fill"></i>';
    localStorage.setItem('colorTheme', 'light');
  } else {
    document.documentElement.setAttribute('data-bs-theme', 'dark');
    colorModeToggler.innerHTML = '<i class="bi bi-moon-fill"></i>';
    localStorage.setItem('colorTheme', 'dark');
  }
});
