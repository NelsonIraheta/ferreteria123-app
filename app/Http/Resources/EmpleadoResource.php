<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'dni'=> $this->dni,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'cargo' => (float) $this->cargo,
            'salario'=> (float) $this->salario,
            'id_empleado' => $this->id_empleado,
            'fecha_registro' => $this->created_at ? $this->created_at->format('d/m/Y H:1 A') : null,
        ];
    }
}
