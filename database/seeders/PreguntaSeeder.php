<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreguntaEncuesta;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PreguntaEncuesta::create([
            'seccion_id' => 1,
            'seccion_encuesta_id' => 1,
            'pregunta' => '¿Cuánto tiempo esperó?',
            'tipo_respuesta' => 'radio',
            'requerida' => true,
            'orden' => 5,
            'opciones' => json_encode([
                'custom_options' => [
                    '15_min' => '15 minutos',
                    '30_min' => '30 minutos',
                    '1_hora' => '1 hora',
                    '2_horas' => '2 horas',
                    'mas_2_horas' => 'Más de 2 horas'
                ]
            ])
        ]);


    }
}
