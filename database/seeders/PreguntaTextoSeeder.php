<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreguntaEncuesta;

class PreguntaTextoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Texto simple (una línea)
        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 2,
            'seccion_id' => 2,
            'pregunta' => 'Nombre del evaluador principal',
            'tipo_respuesta' => 'texto',
            'requerida' => true,
            'opciones' => json_encode([
                'multilinea' => false,
                'maxlength' => 100,
                'placeholder' => 'Ingrese el nombre completo'
            ])
        ]);

        // Texto multilínea
        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 2,
            'seccion_id' => 2,
            'pregunta' => 'Comentarios adicionales',
            'tipo_respuesta' => 'texto',
            'requerida' => false,
            'opciones' => json_encode([
                'multilinea' => true,
                'filas' => 4,
                'maxlength' => 500,
                'placeholder' => 'Escriba aquí sus observaciones...'
            ])
        ]);
    }
}
