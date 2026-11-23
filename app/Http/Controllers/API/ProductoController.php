<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => ProductoResource::collection($productos),
            'pagination' => [
                'total' => $productos->total(),
                'per_page' => $productos->perPage(),
                'current_page' => $productos->currentPage(),
                'last_page' => $productos->lastPage()
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validados = $request->validate([
            //'codigo_barra' => 'required|string|unique:productos,codigo_varra|max:30',
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|mini:0.01',
            'stock' => 'required|integer|min:0',
            //'categoria_id' => 'required|exists:categorias,id'
        ]);
        $producto = Producto::create($validados);
        return response()->json([
            'status'  => 'created',
            'message' => 'Artículo ingresado exitosamente al inventario de Ferretería La Bendición',
            'data'    => new ProductoResource($producto)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Buscamos el producto en MySQL
        $producto = Producto::find($id);

        // Si no existe, devolvemos error semántico 404
        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => "El producto con ID #{$id} no existe en Ferretería La Bendición"
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'data'   => new ProductoResource($producto)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $producto = Producto::find($id);

        // Si no existe, devolvemos error semántico 404
        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => "El producto con ID #{$id} no existe en Ferretería La Bendición"
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'data'   => new ProductoResource($producto)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El producto a eliminar no existe en bodega'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'Producto dado de baja exitosamente'
        ], 200);
    }
}
