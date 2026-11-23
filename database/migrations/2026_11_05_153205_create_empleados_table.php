<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(Schema::hasTable('empleados')){
            return;
        };
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 13);
            $table->string('nombre');
            $table->string('apellido');
            $table->enum('cargo', ['cajero', 'bodeguero']);
            $table->decimal('salario');
            $table->string('id_empleado', 13);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
