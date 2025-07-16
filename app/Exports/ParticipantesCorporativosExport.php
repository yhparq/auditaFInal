<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantesCorporativosExport implements FromCollection, WithHeadings, WithMapping
{
    protected $participantes;

    public function __construct($participantes)
    {
        $this->participantes = $participantes;
    }

    public function collection()
    {
        return $this->participantes;
    }

    public function headings(): array
    {
        return [
            'ID',
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
            'Nombre Corporativo',
            'Código Pago',
            'Comprobante',
            'RUC',
            'Estado',
            'Fecha Creación',
            'Fecha Actualización'
        ];
    }

    public function map($participante): array
    {
        return [
            $participante->id,
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
            $participante->updated_at->format('d/m/Y H:i'),
        ];
    }
}