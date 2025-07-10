<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CursoController extends Controller
{
    // ===========================================
    // MÉTODOS PÚBLICOS (Aula Virtual)
    // ===========================================

    /**
     * Aula virtual pública - cualquier persona puede ver
     */
    public function aulaVirtual(Request $request)
    {
        $cursos = Curso::activos()
            ->when($request->search, function ($query, $search) {
                $query->where('nombre_curso', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->orderBy('fecha_curso', 'asc')
            ->paginate(10);

        return Inertia::render('AulaVirtual', [
            'cursos' => $cursos,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Mostrar curso individual (público)
     */
    public function mostrarCurso(Curso $curso)
    {
        // Solo mostrar si está activo
        if (!$curso->activo) {
            abort(404);
        }

        return Inertia::render('AulaVirtual/Curso', [
            'curso' => $curso,
        ]);
    }

    // ===========================================
    // MÉTODOS PRIVADOS (Administración)
    // ===========================================

    /**
     * Display a listing of the resource (Admin).
     */
    public function index(Request $request)
    {
        $cursos = Curso::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nombre_curso', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->when($request->filter, function ($query, $filter) {
                switch ($filter) {
                    case 'proximos':
                        $query->proximos();
                        break;
                    case 'pasados':
                        $query->pasados();
                        break;
                    case 'hoy':
                        $query->whereDate('fecha_curso', now()->toDateString());
                        break;
                    case 'activos':
                        $query->where('activo', true);
                        break;
                    case 'inactivos':
                        $query->where('activo', false);
                        break;
                }
            })
            ->latest()
            ->paginate(12);

        return Inertia::render('Cursos/Index', [
            'cursos' => $cursos,
            'filters' => $request->only(['search', 'filter']),
        ]);
    }

    /**
     * Show the form for creating a new resource (Admin).
     */
    public function create()
    {
        return Inertia::render('Cursos/Create');
    }

    /**
     * Store a newly created resource in storage (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:255',
            'fecha_curso' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'link_reunion' => 'required|url|max:500',
            'material_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB máximo
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $data = $request->except('material_pdf');

        // Subir PDF si existe
        if ($request->hasFile('material_pdf')) {
            $pdf = $request->file('material_pdf');
            $filename = time() . '_' . $pdf->getClientOriginalName();
            $path = $pdf->storeAs('cursos/materiales', $filename, 'public');
            $data['material_pdf'] = $path;
        }

        Curso::create($data);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource (Admin).
     */
    public function show(Curso $curso)
    {
        return Inertia::render('Cursos/Show', [
            'curso' => $curso,
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin).
     */
    public function edit(Curso $curso)
    {
        return Inertia::render('Cursos/Edit', [
            'curso' => $curso,
        ]);
    }

    /**
     * Update the specified resource in storage (Admin).
     */
    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:255',
            'fecha_curso' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'link_reunion' => 'required|url|max:500',
            'material_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $data = $request->except('material_pdf');

        // Subir nuevo PDF si existe
        if ($request->hasFile('material_pdf')) {
            // Eliminar PDF anterior
            if ($curso->material_pdf && Storage::disk('public')->exists($curso->material_pdf)) {
                Storage::disk('public')->delete($curso->material_pdf);
            }

            // Guardar nuevo PDF
            $pdf = $request->file('material_pdf');
            $filename = time() . '_' . $pdf->getClientOriginalName();
            $path = $pdf->storeAs('cursos/materiales', $filename, 'public');
            $data['material_pdf'] = $path;
        }

        $curso->update($data);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage (Admin).
     */
    public function destroy(Curso $curso)
    {
        // Eliminar PDF del storage
        if ($curso->material_pdf && Storage::disk('public')->exists($curso->material_pdf)) {
            Storage::disk('public')->delete($curso->material_pdf);
        }

        // Eliminar registro de la BD
        $curso->delete();

        return redirect()->route('cursos.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }
}