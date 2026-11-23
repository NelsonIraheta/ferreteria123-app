<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => EmpleadoResource::collection($empleados),
            'pagination' => [
                'total' => $empleados->total(),
                'per_page' => $empleados->perPage(),
                'current_page' => $empleados->currentPage(),
                'last_page' => $empleados->lastPage()
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validados = $request->validate([
            'dni'=> 'required|string|max:13',
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|mini:0.01',
            'stock' => 'required|integer|min:0',
        ]);
        $empleado = Empleado::create($validados);
        return response()->json([
            'status'  => 'created',
            'message' => 'Artículo ingresado exitosamente al inventario de Ferretería La Bendición',
            'data'    => new EmpleadoResource($empleado)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::find($id);

        // Si no existe, devolvemos error semántico 404
        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => "El empleado con ID #{$id} no existe en Ferretería La Bendición"
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'data'   => new EmpleadoResource($empleado)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::find($id);

        // Si no existe, devolvemos error semántico 404
        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => "El empleado con ID #{$id} no existe en Ferretería La Bendición"
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'data'   => new EmpleadoResource($empleado)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El empleado a eliminar no existe.'
            ], 404);
        }

        $empleado->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'empleado dado de baja exitosamente'
        ], 200);
    }
}
