import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


document.addEventListener("DOMContentLoaded", () => {
    const globalModal = new bootstrap.Modal(document.getElementById('globalModal'));
    const modalContent = document.getElementById('globalModalContent');

    // Botón "Nuevo Egreso"
    document.getElementById('btnNuevoEgreso')?.addEventListener('click', () => {
        fetch('/egresos/partials/modal-form')
            .then(res => res.text())
            .then(html => {
                modalContent.innerHTML = html;
                globalModal.show();
            });
    });

    // Botón "Ver Conceptos"
    document.getElementById('btnVerConceptos')?.addEventListener('click', () => {
        fetch('/egresos/partials/modal-concepto')
            .then(res => res.text())
            .then(html => {
                modalContent.innerHTML = html;
                globalModal.show();
            });
    });
});
