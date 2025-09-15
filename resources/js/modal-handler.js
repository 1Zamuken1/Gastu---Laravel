import $ from 'jquery';
import * as bootstrap from 'bootstrap';

document.addEventListener("DOMContentLoaded", () => {
    const globalModal = new bootstrap.Modal(document.getElementById('globalModal'));
    const modalContent = document.getElementById('globalModalContent');

    // ==============================
    // Botón "Nuevo Egreso"
    // ==============================
    document.getElementById('btnNuevoEgreso')?.addEventListener('click', (e) => {
        const url = e.target.dataset.url; // <-- viene desde Blade con route('egresos.form')

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error("Error cargando el formulario de egreso");
                return res.text();
            })
            .then(html => {
                modalContent.innerHTML = html;
                globalModal.show();
            })
            .catch(err => console.error(err));
    });

    // ==============================
    // Botón "Ver Conceptos"
    // ==============================
    document.getElementById('btnVerConceptos')?.addEventListener('click', (e) => {
        const url = e.target.dataset.url; // <-- viene desde Blade con route('conceptoegresos.modal')

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error("Error cargando los conceptos");
                return res.text();
            })
            .then(html => {
                modalContent.innerHTML = html;
                globalModal.show();
            })
            .catch(err => console.error(err));
    });
});
