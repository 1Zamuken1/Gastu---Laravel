<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConceptoEgreso;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConceptoEgresoController extends Controller
{
    public function index(){
    $conceptosEgreso = ConceptoEgreso::all();

    $conceptoEgreso = ConceptoEgreso::orderBy('concepto_egreso_id', 'desc')->paginate(10);

    return view('concepto_egreso.index', compact('conceptoEgresos'));
}


    public function store(Request $request): RedirectResponse{
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
            //'usuario_id' => 'nullable|integer',
        ]);
    }

    public function show(ConceptoEgreso $conceptoEgreso): View{
        return view('concepto_egreso.show', compact('conceptoEgreso'));
    }

    public function destroy(ConceptoEgreso $conceptoEgreso): RedirectResponse{
        $conceptoEgreso->delete();
        return redirect()->route('concepto_egreso.index')->with('success', 'Concepto de egreso eliminado exitosamente.');
    }

    public function update(Request $request, ConceptoEgreso $conceptoEgreso): RedirectResponse{
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $conceptoEgreso->update($validated);

        return redirect()->route('concepto_egreso.index')->with('success', 'Concepto de egreso actualizado exitosamente.');

    }
    
}
