<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreguntaEncuesta;

class PreguntaEvaluadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 2,
            'seccion_id' => 2,
            'pregunta' => 'Presidente de la Comisión Técnica',
            'tipo_respuesta' => 'select',
            'requerida' => true,
            'opciones' => json_encode([
                'tipo_evaluador' => 'presidentes'
            ])
        ]);

        // Para seleccionar especialista en seguridad
        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 2,
            'seccion_id' => 2,
            'pregunta' => 'Especialista en Seguridad Contra Incendios',
            'tipo_respuesta' => 'select',
            'requerida' => true,
            'opciones' => json_encode([
                'tipo_evaluador' => 'especialistas',
                'filtro_adicional' => 'Seguridad contra incendios'
            ])
        ]);
    }
}
