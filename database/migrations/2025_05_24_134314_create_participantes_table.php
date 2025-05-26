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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni', 8)->unique();
            $table->string('departamento');
            $table->string('provincia');
            $table->string('distrito');
            $table->text('direccion_actual')->nullable();
            $table->enum('tipo_participante', ['individual', 'corporativo']);
            $table->string('nombre_corporativo')->nullable();
            $table->string('codigo_pago');
            $table->string('foto_voucher')->nullable();
            $table->enum('comprobante', ['boleta', 'factura'])->default('boleta');
            $table->string('numero_ruc')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
