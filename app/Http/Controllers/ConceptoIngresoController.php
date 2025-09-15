<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConceptoIngreso;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConceptoIngresoController extends Controller
{
    public function index(){
    $conceptosIngreso = ConceptoIngreso::all();

    $conceptoIngresos = ConceptoIngreso::orderBy('concepto_ingreso_id', 'desc')->paginate(10);

    return view('concepto_ingreso.index', compact('conceptoIngresos'));
}


    public function store(Request $request): RedirectResponse{
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
            //'usuario_id' => 'nullable|integer',
        ]);
    }

    public function show(ConceptoIngreso $conceptoIngreso): View{
        return view('concepto_ingreso.show', compact('conceptoIngreso'));
    }

    public function destroy(ConceptoIngreso $conceptoIngreso): RedirectResponse{
        $conceptoIngreso->delete();
        return redirect()->route('concepto_ingreso.index')->with('success', 'Concepto de ingreso eliminado exitosamente.');
    }

    public function update(Request $request, ConceptoIngreso $conceptoIngreso): RedirectResponse{
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $conceptoIngreso->update($validated);

        return redirect()->route('concepto_ingreso.index')->with('success', 'Concepto de ingreso actualizado exitosamente.');

    }
    
}
