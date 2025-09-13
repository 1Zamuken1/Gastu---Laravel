@extends('layouts.app')

@section('title', 'Egresos')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        
      <button class="btn btn-success" id="btnNuevoEgreso">
            Nuevo Egreso
        </button>

        <button class="btn btn-secondary" id="btnVerConceptos">
            Ver Conceptos
        </button>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="egresosTable" class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($egresos as $e)
                        <tr>
                            <td>{{ $e->egreso_id }}</td>
                            <td>{{ $e->concepto_egreso?->descripcion ?? '---' }}</td>
                            <td>${{ number_format($e->monto, 2) }}</td>
                            <td>{{ $e->tipo }}</td>
                            <td>{{ optional($e->fecha_registro)->format('Y-m-d') }}</td>
                            <td>{{ $e->descripcion }}</td>
                            <td class="text-end">
                                <a href="{{ route('egresos.show', $e) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('egresos.edit', $e) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('egresos.destroy', $e) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este egreso?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay egresos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#egresosTable').DataTable({
            "language": {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });
    });
</script>
@endpush
{{-- Aquí se inyectan los modales de esta vista --}}
@section('modals')
    @include('egresos.partials.modal-conceptos')
    @include('egresos.partials.modal-form') 
@endsection
