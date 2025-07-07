<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuesta;
use App\Models\SeccionEncuesta;
use App\Models\PreguntaEncuesta;

class EncuestassssSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run()
    {
        $encuesta = Encuesta::create([
            'titulo' => 'Encuesta de Calidad de Evaluadores',
            'descripcion' => 'Evaluación del desempeño de los evaluadores de propuestas arquitectónicas',
            'numero_expediente' => '1',
            'municipalidad_tramite' => '1',
            'fecha_entrevista' => now(),
            'activa' => true
        ]);

        // Sección Técnica
        $seccionTecnica = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'OPINIÓN DEL CONOCIMIENTO TÉCNICO Y NORMATIVO',
            'descripcion' => 'Califique cada ítem del 1 al 5, siendo 1 que el servicio fue insatisfactorio y 5 que el servicio fue muy satisfactorio',
            'orden' => 1
        ]);

        PreguntaEncuesta::create([
            'seccion_id' => $seccionTecnica->id,
            'encuesta_id' => $encuesta->id,
            'pregunta' => 'Las observaciones tenían sustento normativo específico',
            'tipo_respuesta' => 'radio',
            'requerida' => true,
            'orden' => 1
        ]);

        // Sección Servicio
        $seccionServicio = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'OPINIÓN DE LA CALIDAD DEL SERVICIO',
            'orden' => 2
        ]);

        PreguntaEncuesta::create([
            'seccion_id' => $seccionServicio->id,
            'encuesta_id' => $encuesta->id,
            'pregunta' => '¿Le aclararon sus dudas en la entrevista?',
            'tipo_respuesta' => 'si_no',
            'requerida' => true,
            'orden' => 1
        ]);

        // Sección Evaluadores
        $seccionEvaluadores = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'EVALUACIÓN DE LOS EVALUADORES',
            'orden' => 3
        ]);

        PreguntaEncuesta::create([
            'seccion_id' => $seccionEvaluadores->id,
            'encuesta_id' => $encuesta->id,
            'pregunta' => 'Conocimiento Técnico y Normativo del Presidente',
            'tipo_respuesta' => 'radio',
            'requerida' => true,
            'orden' => 1,
            'evaluador_asociado' => true
        ]);
    }
}
