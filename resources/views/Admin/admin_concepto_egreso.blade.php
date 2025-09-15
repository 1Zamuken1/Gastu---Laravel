@extends('layouts.admin-app')
@section('title', 'Conceptos de Egreso')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Productos</h1>
    <a href="{{ route('conceptoEgreso.create') }}" class="btn btn-primary">Nuevo</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></td>
            <td>${{ number_format($p->price, 2) }}</td>
            <td>{{ $p->stock }}</td>
            <td class="text-end">
                <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-info">Ver</a>
                <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('products.destroy', $p) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No hay productos</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $products->links() }}

@endsection