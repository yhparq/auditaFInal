<?php

// database/migrations/xxxx_xx_xx_create_asistencias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained('participantes')->onDelete('cascade');

            // Solo los campos que necesitas
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni');
            $table->string('tipo_participante_categoria')->nullable();

            // Fecha y hora
            $table->date('fecha');
            $table->string('hora'); // Cambiar de time a string
            $table->timestamps();

            // Índices
            $table->index(['participante_id', 'fecha']);
            $table->index('dni');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};
