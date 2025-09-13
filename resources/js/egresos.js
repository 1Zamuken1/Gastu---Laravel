document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById('btnNuevoEgreso');
  if (!btn) return;

  btn.addEventListener('click', function () {
    const url = "{{ route('conceptoegresos.modal') }}"; // o pásala desde data-url
    const container = document.getElementById('globalModalContent');

    container.innerHTML = '<div class="p-4 text-center"><i class="fa fa-spinner fa-spin"></i> Cargando...</div>';

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
         container.innerHTML = '<div class="p-4 text-danger">Error al cargar. Intenta de nuevo.</div>';
      });
  });
});
