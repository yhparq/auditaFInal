<?php

namespace App\Exports;

use App\Models\Participante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ParticipantesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Participante::all();
    }

    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'DNI',
            'Correo',
            'Celular',
            'Colegio Departamental',
            'Departamento',
            'Provincia',
            'Distrito',
            'Dirección',
            'Tipo Participante',
            'Categoría',
            'Modalidad',
            'Corporativo',
            'Código Pago',
            'Comprobante',
            'RUC',
            'Estado',
            'Fecha Registro'
        ];
    }

    public function map($participante): array
    {
        return [
            $participante->nombres,
            $participante->apellidos,
            $participante->dni,
            $participante->correo,
            $participante->celular,
            $participante->colegio_departamental,
            $participante->departamento,
            $participante->provincia,
            $participante->distrito,
            $participante->direccion_actual,
            $participante->tipo_participante,
            $participante->tipo_participante_categoria,
            $participante->modalidad_participacion,
            $participante->nombre_corporativo,
            $participante->codigo_pago,
            $participante->comprobante,
            $participante->numero_ruc,
            $participante->estado ? 'Activo' : 'Inactivo',
            $participante->created_at->format('d/m/Y H:i'),
        ];
    }
}