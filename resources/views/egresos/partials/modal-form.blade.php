<div class="modal-header">
    <h5 class="modal-title">Nuevo Egreso</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form id="egresoForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Monto</label>
            <input type="number" class="form-control" name="monto">
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
