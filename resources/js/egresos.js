document.addEventListener('DOMContentLoaded', function() {

  // Función genérica para abrir un modal vía fetch
  function abrirModal(url, cargandoMsg = 'Cargando...') {
    const container = document.getElementById('globalModalContent');
    if (!container) return;

    container.innerHTML = `
      <div class="p-4 text-center">
        <i class="fa fa-spinner fa-spin"></i> ${cargandoMsg}
      </div>
    `;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(res => res.text())
      .then(html => {
        container.innerHTML = html;
        const modalEl = document.getElementById('globalModal');
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
      })
      .catch(err => {
        console.error(err);
        container.innerHTML = `
          <div class="p-4 text-danger">
            Error al cargar. Intenta de nuevo.
          </div>
        `;
      });
  }

  // Botón Nuevo Egreso
  const btnNuevo = document.getElementById('btnNuevoEgreso');
  if (btnNuevo) {
    btnNuevo.addEventListener('click', function () {
      const url = btnNuevo.dataset.url; // <- lee la URL del data-url
      abrirModal(url, 'Cargando formulario...');
    });
  }

  // Botón Ver Conceptos
  const btnConceptos = document.getElementById('btnVerConceptos');
  if (btnConceptos) {
    btnConceptos.addEventListener('click', function () {
      const url = btnConceptos.dataset.url; // <- lee la URL del data-url
      abrirModal(url, 'Cargando conceptos...');
    });
  }

});
