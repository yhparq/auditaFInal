<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $participantes = Participantes::all();
        $participantes = Participante::where('tipo_participante', 'individual')->get();

        return Inertia::render('Participantes/Index', ['participantes' => $participantes]);
    }
    public function indexCoporativos()
    {
        $participantes = Participante::where('tipo_participante', 'corporativo')->get();

        // $participantes = Participantes::all();
        return Inertia::render('Participantes/IndexCorporativos', ['participantes' => $participantes]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Participantes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store1(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:participantes,dni',
            'correo' => 'required|email|unique:participantes,correo',
            'celular' => 'required|string|max:15',
            'colegio_departamental' => 'nullable|string|max:255',
            'departamento' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'distrito' => 'required|string|max:100',
            'direccion_actual' => 'nullable|string|max:255',
            'tipo_participante' => 'required|in:individual,corporativo',
            'tipo_participante_categoria' => 'required|in:pleno,observador,estudiante',
            'modalidad_participacion' => 'required|in:presencial,virtual',
            'codigo_pago' => 'required|string|max:100',
            'foto_voucher' => 'nullable|image|max:2048',
            'comprobante' => 'required|in:boleta,factura',
            'numero_ruc' => 'nullable|required_if:comprobante,factura|string|size:11',
            'nombre_corporativo' => 'nullable|required_if:comprobante,factura|string|max:255',
            'estado' => 'required|boolean',
        ]);

        if ($request->hasFile('foto_voucher')) {
            $data['foto_voucher'] = $request->file('foto_voucher')->store('vouchers', 'public');
        }

        Participante::create($data);

        // return redirect('/registro')->with('success', 'Participante registrado correctamente.');
        return redirect()->route('registro.seleccion')->with('success', '¡Registro exitoso! Ya formas parte de AUDITA 2025. Te esperamos en la hermosa ciudad del lago más alto del mundo.');



    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_corporativo' => 'required|string|max:255',
            'participantes' => 'required|array|min:1',
            'participantes.*.nombres' => 'required|string|max:255',
            'participantes.*.apellidos' => 'required|string|max:255',
            'participantes.*.dni' => 'required|string|size:8|distinct|unique:participantes,dni',
            'participantes.*.correo' => 'required|email|distinct|unique:participantes,correo',
            'participantes.*.celular' => 'required|string|max:15',
            'participantes.*.colegio_departamental' => 'nullable|string|max:255',
            'participantes.*.departamento' => 'required|string|max:100',
            'participantes.*.provincia' => 'required|string|max:100',
            'participantes.*.distrito' => 'required|string|max:100',
            'participantes.*.direccion_actual' => 'nullable|string|max:255',
            'participantes.*.tipo_participante' => 'required|in:individual,corporativo',
            'participantes.*.tipo_participante_categoria' => 'required|in:pleno,observador,estudiante',
            'participantes.*.modalidad_participacion' => 'required|in:presencial,virtual',
            'participantes.*.codigo_pago' => 'required|string|max:100',
            'participantes.*.comprobante' => 'required|in:boleta,factura',
            'participantes.*.numero_ruc' => 'nullable|required_if:participantes.*.comprobante,factura|string|size:11',
            'participantes.*.nombre_corporativo' => 'nullable|required_if:participantes.*.comprobante,factura|string|max:255',
            'participantes.*.estado' => 'nullable|boolean',

        ]);

        // Guardar imagen si existe y agregarla a cada participante
        if ($request->hasFile('voucher_global')) {
            $ruta = $request->file('voucher_global')->store('vouchers', 'public');
        } else {
            $ruta = null;
        }

        foreach ($data['participantes'] as $p) {
            $p['foto_voucher'] = $ruta;
            $p['estado'] = false; // ← fuerza a inactivo

            Participante::create($p);
        }

        // return redirect('/registro')->with('success', 'Participante registrado correctamente.');
        // return redirect()->route('registro.seleccion')->with('success', 'Participante registrado correctamente.');

        return redirect()->route('registro.seleccion')->with('success', '¡Registro exitoso! Ya formas parte de AUDITA 2025. Te esperamos en la hermosa ciudad del lago más alto del mundo.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Participante $participante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participante $participante)
    {
        return Inertia::render('Participantes/Edit', [
            'participante' => $participante,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participante $participante)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:participantes,dni,' . $participante->id,
            'correo' => 'required|email|unique:participantes,correo,' . $participante->id,
            'celular' => 'required|string|max:15',
            'colegio_departamental' => 'nullable|string|max:255',
            'departamento' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'distrito' => 'required|string|max:100',
            'direccion_actual' => 'nullable|string|max:255',
            'tipo_participante' => 'required|in:individual,corporativo',
            'tipo_participante_categoria' => 'required|in:pleno,observador,estudiante',
            'modalidad_participacion' => 'required|in:presencial,virtual',
            'codigo_pago' => 'required|string|max:100',
            'foto_voucher' => 'nullable|image|max:2048',
            'comprobante' => 'required|in:boleta,factura',
            'numero_ruc' => 'nullable|required_if:comprobante,factura|string|size:11',
            'nombre_corporativo' => 'nullable|required_if:comprobante,factura|string|max:255',
            'estado' => 'required|boolean',
        ]);

        if ($request->hasFile('foto_voucher')) {
            if ($participante->foto_voucher) {
                Storage::disk('public')->delete($participante->foto_voucher);
            }
            $data['foto_voucher'] = $request->file('foto_voucher')->store('vouchers', 'public');
        }

        $participante->update($data);

        return redirect()->route('participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participante $participante)
    {
        if ($participante->foto_voucher) {
            Storage::disk('public')->delete($participante->foto_voucher);
        }

        $participante->delete();

        return redirect()->route('participantes.index')->with('success', 'Participante eliminado correctamente.');
    }
}