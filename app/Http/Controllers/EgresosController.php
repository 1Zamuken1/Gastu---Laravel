<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Egreso;
use App\Models\ConceptoEgreso;
use Illuminate\Http\Request;

class EgresosController extends Controller
{
    // Mostrar listado de egresos
   public function index()
{
    $egresos = Egreso::all();
    $conceptoEgresos = ConceptoEgreso::all(); // <- aquí cargas los conceptos

    return view('egresos.index', compact('egresos', 'conceptoEgresos'));
}

    // Mostrar formulario para crear un nuevo egreso
    public function create()
{
    $conceptoEgresos = ConceptoEgreso::all();
    return view('egresos.partials.modal-form', compact('conceptoEgresos'));
}



    // Guardar un nuevo egreso
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:50',
            'monto' => 'required|numeric',
            'descripcion' => 'nullable|string|max:255',
            'fecha_registro' => 'required|date',
            'concepto_egreso_id' => 'required|integer|exists:concepto_egreso,concepto_egreso_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Egreso::create($request->only([
            'tipo',
            'monto',
            'descripcion',
            'fecha_registro',
            'concepto_egreso_id'
        ]));

        return redirect()->route('egresos.index')
            ->with('success', 'Egreso creado exitosamente');
    }

    // Mostrar un egreso en detalle
    public function show($id)
    {
        $egreso = Egreso::findOrFail($id);
        return view('egresos.show', compact('egreso'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $egreso = Egreso::findOrFail($id);
        return view('egresos.edit', compact('egreso'));
    }

    // Actualizar un egreso existente
    public function update(Request $request, $id)
    {
        $egreso = Egreso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|max:50',
            'monto' => 'required|numeric',
            'descripcion' => 'nullable|string|max:255',
            'fecha_registro' => 'required|date',
            'concepto_egreso_id' => 'required|integer|exists:concepto_egreso,concepto_egreso_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $egreso->update($request->only([
            'tipo',
            'monto',
            'descripcion',
            'fecha_registro',
            'concepto_egreso_id'
        ]));

        return redirect()->route('egresos.index')
            ->with('success', 'Egreso actualizado exitosamente');
    }

    // Eliminar un egreso
    public function destroy($id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->delete();

        return redirect()->route('egresos.index')
            ->with('success', 'Egreso eliminado exitosamente');
    }


}
