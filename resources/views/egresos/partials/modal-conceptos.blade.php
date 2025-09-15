<div class="modal-header">
    <h5 class="modal-title">Seleccionar Concepto</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <ul class="list-group">
        @forelse($conceptoEgresos as $concepto)
            <li class="list-group-item">
                {{ $concepto->nombre }}
            </li>
        @empty
            <li class="list-group-item text-muted">No hay conceptos registrados</li>
        @endforelse
    </ul>
</div>
