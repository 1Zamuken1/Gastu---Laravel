<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProyeccionIngreso;
use Illuminate\Support\Facades\Validator;

class ProyeccionIngresoController extends Controller
{
    public function index()
    {
        $proyecciones = ProyeccionIngreso::with('conceptoIngreso')->get();

        if ($proyecciones->isEmpty()) {
            return response()->json([
                'message' => 'No hay proyecciones de ingresos registradas',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'proyecciones' => $proyecciones,
            'status'       => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'monto_programado'    => 'required|numeric',
            'descripcion'         => 'required|string|max:100',
            'fecha_fin'           => 'nullable|date',
            'activo'              => 'required|boolean',
            'concepto_ingreso_id' => 'required|integer|exists:concepto_ingreso,concepto_ingreso_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $proyeccion = ProyeccionIngreso::create($validator->validated());

        return response()->json([
            'message'    => 'Proyección de ingreso creada exitosamente',
            'proyeccion' => $proyeccion,
            'status'     => 201
        ], 201);
    }

    public function show($id)
    {
        $proyeccion = ProyeccionIngreso::with('conceptoIngreso')->find($id);

        if (!$proyeccion) {
            return response()->json([
                'message' => 'Proyección de ingreso no encontrada',
                'status'  => 404
            ], 404);
        }

        return response()->json([
            'proyeccion' => $proyeccion,
            'status'     => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $proyeccion = ProyeccionIngreso::find($id);

        if (!$proyeccion) {
            return redirect()->route('ingresos.index')->with('error', 'Proyección no encontrada.');
        }

        $data = $request->validate([
            'monto_programado'    => 'required|numeric',
            'descripcion'         => 'required|string|max:100',
            'fecha_fin'           => 'nullable|date',
            'activo'              => 'required|boolean',
            'concepto_ingreso_id' => 'required|integer|exists:concepto_ingreso,concepto_ingreso_id',
        ]);

        $proyeccion->update($data);

        return redirect()->route('ingresos.index')->with('success', 'Proyección actualizada correctamente.');
    }

    public function destroy($id)
    {
        $proyeccion = ProyeccionIngreso::find($id);

        if (!$proyeccion) {
            return redirect()->route('ingresos.index')->with('error', 'Proyección no encontrada.');
        }

        $proyeccion->delete();

        return redirect()->route('ingresos.index')->with('success', 'Proyección eliminada correctamente.');
    }

    // ✅ Extra: actualización parcial (PATCH)
    public function updatePartial(Request $request, $id)
    {
        $proyeccion = ProyeccionIngreso::find($id);

        if (!$proyeccion) {
            return response()->json([
                'message' => 'Proyección de ingreso no encontrada',
                'status'  => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'monto_programado'    => 'nullable|numeric',
            'descripcion'         => 'nullable|string|max:100',
            'fecha_fin'           => 'nullable|date',
            'activo'              => 'nullable|boolean',
            'concepto_ingreso_id' => 'nullable|integer|exists:concepto_ingreso,concepto_ingreso_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors'  => $validator->errors(),
                'status'  => 400
            ], 400);
        }

        $proyeccion->update($validator->validated());

        return response()->json([
            'message'    => 'Proyección actualizada parcialmente',
            'proyeccion' => $proyeccion,
            'status'     => 200
        ], 200);
    }
}
