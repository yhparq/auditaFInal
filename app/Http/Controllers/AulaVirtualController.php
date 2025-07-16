<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AulaVirtualController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (Auth::guard('participante')->check()) {
            return redirect()->route('aula-virtual.dashboard');
        }

        // Retorna el componente Vue de Inertia
        return Inertia::render('AulaVirtual/Login');
    }

    /**
     * Procesar el login - Versión SIN Auth::attempt
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'dni' => 'required',
        ]);
        
        // Buscar participante manualmente en la base de datos
        $participante = \App\Models\Participante::where('correo', $credentials['correo'])
            ->where('estado', 1) // Solo participantes activos
            ->first();
        
        // Verificar si existe el participante y si el DNI coincide
        if ($participante && $participante->dni === $credentials['dni']) {
            // Login manual usando Auth::guard()->login() - SIN attempt()
            Auth::guard('participante')->login($participante);
            
            // Regenerar la sesión por seguridad
            $request->session()->regenerate();
            
            // Redirigir al dashboard
            return redirect()->route('aula-virtual.dashboard');
        }
        
        // Si no coinciden las credenciales, devolver error
        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros o tu cuenta no está activa.',
        ])->onlyInput('correo');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::guard('participante')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('aula-virtual.login');
    }

    /**
     * Mostrar el dashboard del aula virtual
     */
    public function dashboard()
    {
        try {
            // Obtener participante autenticado con el guard 'participante'
            $participante = Auth::guard('participante')->user();

            if (!$participante) {
                return redirect()->route('aula-virtual.login');
            }

            // Obtener fechas disponibles
            $fechasDisponibles = [];

            try {
                $fechas = DB::table('cursos')
                    ->where('activo', true)
                    ->whereNotNull('fecha_curso')
                    ->select(DB::raw('DATE(fecha_curso) as fecha'))
                    ->distinct()
                    ->orderBy('fecha')
                    ->pluck('fecha')
                    ->toArray();

                $fechasDisponibles = $fechas;
                Log::info('Fechas encontradas: ' . json_encode($fechasDisponibles));
            } catch (\Exception $e) {
                Log::error('Error obteniendo fechas: ' . $e->getMessage());
                $fechasDisponibles = [];
            }

            return Inertia::render('AulaVirtual/Dashboard', [
                'participante' => [
                    'id' => $participante->id,
                    'nombres' => $participante->nombres,
                    'apellidos' => $participante->apellidos,
                    'correo' => $participante->correo,
                    'estado' => $participante->estado,
                    'dni' => $participante->dni
                ],
                'fechasDisponibles' => $fechasDisponibles
            ]);
        } catch (\Exception $e) {
            Log::error('Error en dashboard: ' . $e->getMessage());
            return redirect()->route('aula-virtual.login');
        }
    }

    /**
     * Obtener cursos filtrados por fecha (método simple)
     */
    public function cursosPorFecha(Request $request)
    {
        try {
            $fecha = $request->input('fecha');

            Log::info('Buscando cursos para fecha: ' . $fecha);

            if (!$fecha) {
                return response()->json(['cursos' => []]);
            }

            // Buscar cursos usando DATE() para comparar solo la fecha
            $cursos = DB::table('cursos')
                ->where('activo', true)
                ->whereRaw('DATE(fecha_curso) = ?', [$fecha])
                ->orderBy('hora_inicio')
                ->get();

            Log::info('Cursos encontrados: ' . $cursos->count());

            // Convertir a array y agregar estado
            $cursosFormateados = $cursos->map(function ($curso) {
                return [
                    'id' => $curso->id,
                    'nombre_curso' => $curso->nombre_curso,
                    'descripcion' => $curso->descripcion ?? '',
                    'fecha_curso' => $curso->fecha_curso,
                    'hora_inicio' => $curso->hora_inicio,
                    'hora_fin' => $curso->hora_fin,
                    'material_pdf' => $curso->material_pdf,
                    'link_reunion' => $curso->link_reunion,
                    'estado' => $this->determinarEstado($curso),
                    'puede_acceder_reunion' => $this->puedeAcceder($curso)
                ];
            })->toArray();

            return response()->json(['cursos' => $cursosFormateados]);
        } catch (\Exception $e) {
            Log::error('Error en cursosPorFecha: ' . $e->getMessage());

            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage(),
                'cursos' => []
            ], 500);
        }
    }

    /**
     * Determinar estado del curso de forma simple
     */
    private function determinarEstado($curso)
    {
        $hoy = date('Y-m-d');
        $fechaCurso = date('Y-m-d', strtotime($curso->fecha_curso));

        if ($fechaCurso > $hoy) {
            return 'proximamente';
        } elseif ($fechaCurso == $hoy) {
            // Si es hoy, verificar la hora
            if ($curso->hora_inicio && $curso->hora_fin) {
                $horaActual = date('H:i');
                if ($horaActual < $curso->hora_inicio) {
                    return 'proximamente';
                } elseif ($horaActual >= $curso->hora_inicio && $horaActual <= $curso->hora_fin) {
                    return 'en_vivo';
                } else {
                    return 'finalizada';
                }
            }
            return 'en_vivo'; // Si no hay hora, asumir que está en vivo
        } else {
            return 'finalizada';
        }
    }

    /**
     * Determinar si puede acceder a la reunión
     */
    private function puedeAcceder($curso)
    {
        $estado = $this->determinarEstado($curso);

        if ($estado === 'en_vivo') {
            return true;
        }

        // Permitir acceso 15 minutos antes si es hoy
        if ($estado === 'proximamente') {
            $hoy = date('Y-m-d');
            $fechaCurso = date('Y-m-d', strtotime($curso->fecha_curso));

            if ($fechaCurso == $hoy && $curso->hora_inicio) {
                $horaActual = date('H:i');
                $horaInicio = date('H:i', strtotime($curso->hora_inicio . ' -15 minutes'));

                return $horaActual >= $horaInicio;
            }
        }

        return false;
    }

    /**
     * Descargar material del curso
     */
    public function descargarMaterial($cursoId)
    {
        try {
            $curso = DB::table('cursos')->where('id', $cursoId)->where('activo', true)->first();

            if (!$curso) {
                return response()->json(['error' => 'Curso no encontrado'], 404);
            }

            if (!$curso->material_pdf) {
                return response()->json(['error' => 'Material no disponible'], 404);
            }

            $filePath = storage_path('app/public/' . $curso->material_pdf);

            if (!file_exists($filePath)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }

            return response()->download($filePath, $curso->nombre_curso . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error descargando material: ' . $e->getMessage());
            return response()->json(['error' => 'Error al descargar el archivo'], 500);
        }
    }

    /**
     * Acceder a la reunión del curso
     */
    public function accederReunion($cursoId)
    {
        try {
            $curso = DB::table('cursos')->where('id', $cursoId)->where('activo', true)->first();

            if (!$curso) {
                return response()->json(['error' => 'Curso no encontrado'], 404);
            }

            if (!$curso->link_reunion) {
                return response()->json(['error' => 'Link de reunión no disponible'], 404);
            }

            $puedeAcceder = $this->puedeAcceder($curso);

            if (!$puedeAcceder) {
                $estado = $this->determinarEstado($curso);
                $mensaje = $estado === 'finalizada'
                    ? 'La reunión ya ha finalizado'
                    : 'La reunión aún no está disponible';
                return response()->json(['error' => $mensaje], 403);
            }

            return response()->json([
                'link_reunion' => $curso->link_reunion,
                'nombre_curso' => $curso->nombre_curso
            ]);
        } catch (\Exception $e) {
            Log::error('Error accediendo a reunión: ' . $e->getMessage());
            return response()->json(['error' => 'Error al acceder a la reunión'], 500);
        }
    }

    /**
     * Debug simplificado
     */
    public function debug()
    {
        try {
            $info = [
                'database_connection' => 'OK',
                'cursos_count' => DB::table('cursos')->count(),
                'cursos_activos' => DB::table('cursos')->where('activo', true)->count(),
                'fechas_disponibles' => DB::table('cursos')
                    ->where('activo', true)
                    ->select(DB::raw('DATE(fecha_curso) as fecha'))
                    ->distinct()
                    ->pluck('fecha'),
                'cursos_detalle' => DB::table('cursos')
                    ->where('activo', true)
                    ->select('id', 'nombre_curso', 'fecha_curso', DB::raw('DATE(fecha_curso) as fecha_solo'))
                    ->get()
            ];

            return response()->json($info);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}