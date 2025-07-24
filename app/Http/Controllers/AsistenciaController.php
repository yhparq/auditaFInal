<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AsistenciaController extends Controller
{
    // Vista principal
    public function index()
    {
        $asistencias = Asistencia::whereDate('fecha', Carbon::today())
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ->map(function ($asistencia) {
                                    return [
                                        'id' => $asistencia->id,
                                        'nombre' => $asistencia->nombre_completo,
                                        'dni' => $asistencia->dni,
                                        'tipo' => $asistencia->tipo_participante_categoria,
                                        'hora' => is_string($asistencia->hora) ? $asistencia->hora : $asistencia->hora->format('H:i'),
                                        'fecha' => $asistencia->fecha->format('d/m/Y')
                                    ];
                                });

        return Inertia::render('Asistencias/Index', [
            'asistencias' => $asistencias->toArray(),
            'total' => $asistencias->count(),
        ]);
    }

    // Solo registrar asistencia
    public function verificar(Request $request)
    {
        $dni = trim($request->dni);

        // Buscar participante activo
        $participante = Participante::where('dni', $dni)
                                  ->where('estado', 1)
                                  ->first();

        if (!$participante) {
            return response()->json([
                'success' => false,
                'message' => 'DNI no encontrado'
            ]);
        }

        // Registrar asistencia (siempre registra, no verifica duplicados)
        Asistencia::create([
            'participante_id' => $participante->id,
            'nombres' => $participante->nombres,
            'apellidos' => $participante->apellidos,
            'dni' => $dni,
            'tipo_participante_categoria' => $participante->tipo_participante_categoria,
            'fecha' => Carbon::today(),
            'hora' => Carbon::now()->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada',
            'participante' => [
                'nombre' => $participante->nombre_completo,
                'dni' => $participante->dni,
            ]
        ]);
    }

    // Obtener asistencias del día
    public function hoy()
    {
        $asistencias = Asistencia::whereDate('fecha', Carbon::today())
                                ->orderBy('created_at', 'desc')
                                ->get();

        return response()->json([
            'success' => true,
            'asistencias' => $asistencias->map(function ($asistencia) {
                return [
                    'id' => $asistencia->id,
                    'nombre' => $asistencia->nombre_completo,
                    'dni' => $asistencia->dni,
                    'tipo' => $asistencia->tipo_participante_categoria,
                    'hora' => is_string($asistencia->hora) ? $asistencia->hora : $asistencia->hora->format('H:i'),
                    'fecha' => $asistencia->fecha->format('d/m/Y')
                ];
            }),
            'total' => $asistencias->count(),
        ]);
    }
}
