<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DniController extends Controller
{
    public function buscar($dni)
    {
        $token = env('API_PERU_TOKEN'); // Asegúrate que esté en tu .env

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
        ->withoutVerifying() // ⚠️ SOLO para desarrollo local
        ->post('https://apiperu.dev/api/dni', [
            'dni' => $dni,
        ]);

        // Verificar respuesta exitosa
        if ($response->successful() && $response->json('success')) {
            return response()->json($response->json());
        }

        return response()->json([
            'success' => false,
            'message' => 'DNI no encontrado o error en la solicitud',
        ], 404);
    }
}
