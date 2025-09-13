<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\ConceptoIngreso;
use App\Models\ProyeccionIngreso;
use Carbon\Carbon;

class IngresoController extends Controller
{
    public function index()
    {
        // ========================
        // Traer ingresos reales
        // ========================
        $ingresos = Ingreso::with('conceptoIngreso')
            ->get()
            ->map(function ($ingreso) {
                return [
                    'id'          => $ingreso->ingreso_id,
                    'concepto'    => $ingreso->conceptoIngreso->nombre ?? 'Sin concepto',
                    'monto'       => $ingreso->monto,
                    'tipo'        => 'Ingreso',
                    'fecha'       => $ingreso->fecha_registro,
                    'descripcion' => $ingreso->descripcion ?? '',
                    'concepto_id' => $ingreso->concepto_ingreso_id,
                ];
            });

        // ========================
        // Traer proyecciones
        // ========================
        $proyecciones = ProyeccionIngreso::with('conceptoIngreso')
            ->get()
            ->map(function ($proyeccion) {
                return [
                    'id'          => $proyeccion->proyeccion_ingreso_id,
                    'concepto'    => $proyeccion->conceptoIngreso->nombre ?? 'Sin concepto',
                    'monto'       => $proyeccion->monto_programado,
                    'tipo'        => 'Proyección',
                    'fecha'       => $proyeccion->fecha_fin, // solo existe fecha_fin
                    'estado'      => $proyeccion->activo ? 'Activo' : 'Inactivo',
                    'descripcion' => $proyeccion->descripcion,
                    'concepto_id' => $proyeccion->concepto_ingreso_id,
                ];
            });

        // ========================
        // Fusionar ingresos y proyecciones
        // ========================
        $registros = $ingresos->merge($proyecciones);

        // ========================
        // Calcular totales
        // ========================
        $totalIngresos     = Ingreso::sum('monto');
        $totalProyecciones = ProyeccionIngreso::sum('monto_programado');

        $mesActual  = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        $ingresosMes = Ingreso::whereYear('fecha_registro', $anioActual)
            ->whereMonth('fecha_registro', $mesActual)
            ->sum('monto');

        // ========================
        // Traer conceptos (para modal de selección)
        // ========================
        $conceptoIngresos = ConceptoIngreso::all();

        return view('ingresos.index', compact(
            'registros',
            'totalIngresos',
            'totalProyecciones',
            'ingresosMes',
            'conceptoIngresos'
        ));
    }

    public function store(Request $request)
    {
        $tipo = $request->input('tipo');

        if ($tipo === 'Ingreso') {
            $validated = $request->validate([
                'concepto_ingreso_id' => 'required|integer|exists:concepto_ingreso,concepto_ingreso_id',
                'monto'               => 'required|numeric',
                'fecha'               => 'required|date',
                'descripcion'         => 'nullable|string|max:100',
            ]);

            Ingreso::create([
                'concepto_ingreso_id' => $validated['concepto_ingreso_id'],
                'monto'               => $validated['monto'],
                'fecha_registro'      => $validated['fecha'],
                'descripcion'         => $validated['descripcion'] ?? '',
                'tipo'                => 'Ingreso',
            ]);

            return redirect()->route('ingresos.index')->with('success', 'Ingreso creado correctamente.');
        }

        if ($tipo === 'Proyección') {
            $validated = $request->validate([
                'concepto_ingreso_id' => 'required|integer|exists:concepto_ingreso,concepto_ingreso_id',
                'monto'               => 'required|numeric',
                'fecha'               => 'nullable|date', // se guardará en fecha_fin
                'descripcion'         => 'required|string|max:100',
                'estado'              => 'required|in:Activo,Inactivo',
            ]);

            ProyeccionIngreso::create([
                'concepto_ingreso_id' => $validated['concepto_ingreso_id'],
                'monto_programado'    => $validated['monto'],
                'descripcion'         => $validated['descripcion'],
                'fecha_fin'           => $validated['fecha'] ?? null,
                'activo'              => $validated['estado'] === 'Activo' ? 1 : 0,
            ]);

            return redirect()->route('ingresos.index')->with('success', 'Proyección creada correctamente.');
        }

        return redirect()->route('ingresos.index')->with('error', 'Tipo inválido.');
    }

    public function update(Request $request, $id)
    {
        $tipo = $request->input('tipo');

        if ($tipo === 'Ingreso') {
            $validated = $request->validate([
                'concepto_ingreso_id' => 'required|integer|exists:concepto_ingreso,concepto_ingreso_id',
                'monto'               => 'required|numeric',
                'fecha'               => 'required|date',
                'descripcion'         => 'nullable|string|max:100',
            ]);

            $ingreso = Ingreso::findOrFail($id);
            $ingreso->update([
                'concepto_ingreso_id' => $validated['concepto_ingreso_id'],
                'monto'               => $validated['monto'],
                'fecha_registro'      => $validated['fecha'],
                'descripcion'         => $validated['descripcion'] ?? '',
            ]);

            return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente.');
        }

        return redirect()->route('ingresos.index')->with('error', 'Solo se pueden editar ingresos reales desde este formulario.');
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }
}
