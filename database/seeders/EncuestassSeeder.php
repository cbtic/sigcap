<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuesta;
use App\Models\SeccionEncuesta;
use App\Models\PreguntaEncuesta;

class EncuestassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               // Crear encuesta principal
        $encuesta = Encuesta::create([
            'titulo' => 'Encuesta de Calidad de Evaluadores',
            'descripcion' => 'Evaluación del desempeño de los evaluadores de propuestas arquitectónicas',
            'activa' => true
        ]);

        // Sección 1: Opinión Técnica
        $seccion1 = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'OPINIÓN DEL CONOCIMIENTO TÉCNICO Y NORMATIVO',
            'descripcion' => 'Califique cada ítem del 1 al 5, siendo 1 que el servicio fue insatisfactorio y 5 que el servicio fue muy satisfactorio',
            'orden' => 1
        ]);

        PreguntaEncuesta::create([
            'seccion_id' => $seccion1->id,
            'pregunta' => 'Las observaciones tenían sustento normativo específico',
            'tipo_respuesta' => 'rango',
            'requerida' => true,
            'orden' => 1,
            'opciones' => ['min' => 1, 'max' => 5, 'default' => 3]
        ]);

        // Sección 2: Calidad del Servicio
        $seccion2 = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'OPINIÓN DE LA CALIDAD DEL SERVICIO',
            'orden' => 2
        ]);

        PreguntaEncuesta::create([
            'seccion_id' => $seccion2->id,
            'pregunta' => '¿Le aclararon sus dudas en la entrevista?',
            'tipo_respuesta' => 'radio',
            'requerida' => true,
            'orden' => 1,
            'opciones' => ['1' => 'Sí', '0' => 'No']
        ]);
    }
}
