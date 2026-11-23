<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::latest()->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|max:13',
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cargo' => 'required',
            'salario' => 'required|float|min:0',
            'id_empleado' => 'required|max:13'
        ]);

        Empleado::create($request->all());

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return redirect()->route('recursos_humanos.edit', $empleado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'dni' => 'required|max:13',
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cargo' => 'required',
            'salario' => 'required|float|min:0',
            'id_empleado' => 'required|max:13'
        ]);

        $empleado->update($request->all());

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado actualizado exisotsamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('recursos_humanos.index')->with('success', 'Empleado eliminado del registro.');
    }
}
