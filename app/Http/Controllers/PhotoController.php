<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PhotoController extends Controller
{
    // ===========================================
    // MÉTODOS PÚBLICOS (para visitantes)
    // ===========================================

    /**
     * Galería pública - cualquier persona puede ver
     */
    public function publicIndex(Request $request)
    {
        $photos = Photo::query()
            ->when($request->search, function ($query, $search) {
                $query->where('filename', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20); // Más fotos por página para la galería pública

        return Inertia::render('Galeria', [
            'photos' => $photos,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Mostrar foto individual (público)
     */
    public function publicShow(Photo $photo)
    {
        return Inertia::render('Gallery/Show', [
            'photo' => $photo,
        ]);
    }

    // ===========================================
    // MÉTODOS PRIVADOS (solo administradores)
    // ===========================================

    /**
     * Display a listing of the resource (Admin).
     */
    public function index(Request $request)
    {
        $photos = Photo::query()
            ->when($request->search, function ($query, $search) {
                $query->where('filename', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12);

        return Inertia::render('Photos/Index', [
            'photos' => $photos,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource (Admin).
     */
    public function create()
    {
        return Inertia::render('Photos/Create');
    }

    /**
     * Store a newly created resource in storage (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $photo = $request->file('photo');
        $filename = $request->filename;
        
        // Generar nombre único para evitar conflictos
        $extension = $photo->getClientOriginalExtension();
        $uniqueName = time() . '_' . uniqid() . '.' . $extension;
        
        // Guardar archivo
        $path = $photo->storeAs('photos', $uniqueName, 'public');
        
        // Crear registro en BD
        Photo::create([
            'filename' => $filename,
            'file_path' => $path,
        ]);

        return redirect()->route('photos.index')
            ->with('success', 'Foto subida exitosamente.');
    }

    /**
     * Display the specified resource (Admin).
     */
    public function show(Photo $photo)
    {
        return Inertia::render('Photos/Show', [
            'photo' => $photo,
        ]);
    }

    /**
     * Show the form for editing the specified resource (Admin).
     */
    public function edit(Photo $photo)
    {
        return Inertia::render('Photos/Edit', [
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage (Admin).
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $data = [
            'filename' => $request->filename,
        ];

        // Si se sube una nueva imagen
        if ($request->hasFile('photo')) {
            // Eliminar imagen anterior
            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }

            // Guardar nueva imagen
            $newPhoto = $request->file('photo');
            $extension = $newPhoto->getClientOriginalExtension();
            $uniqueName = time() . '_' . uniqid() . '.' . $extension;
            $path = $newPhoto->storeAs('photos', $uniqueName, 'public');
            
            $data['file_path'] = $path;
        }

        $photo->update($data);

        return redirect()->route('photos.index')
            ->with('success', 'Foto actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage (Admin).
     */
    public function destroy(Photo $photo)
    {
        // Eliminar archivo del storage
        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        // Eliminar registro de la BD
        $photo->delete();

        return redirect()->route('photos.index')
            ->with('success', 'Foto eliminada exitosamente.');
    }
}