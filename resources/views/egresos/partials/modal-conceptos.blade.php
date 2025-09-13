<div class="modal-header">
    <h5 class="modal-title">Seleccionar Concepto</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <ul class="list-group">
        @foreach($conceptoEgresos as $concepto)
            <li class="list-group-item">
                {{ $concepto->nombre }}
            </li>
        @endforeach
    </ul>
</div>
