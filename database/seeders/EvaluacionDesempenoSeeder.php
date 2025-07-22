<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuesta;
use App\Models\SeccionEncuesta;
use App\Models\PreguntaEncuesta;

class EvaluacionDesempenoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $encuesta = Encuesta::create([
            'titulo' => 'Evaluación de Desempeño de Delegados',
            'descripcion' => 'Formulario para evaluar el desempeño de los delegados en las comisiones técnicas',
            'activa' => true,
            'numero_expediente' =>'2',
            'municipalidad_tramite' =>'muni',
            'fecha_entrevista' =>'08/07/2025'
            
            
        ]);

        // Sección 1: Datos Generales
        $seccionDatos = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'Datos Generales',
            'orden' => 1
        ]);

        PreguntaEncuesta::create([            
            'seccion_encuesta_id' => $seccionDatos->id,
            'seccion_id' => $seccionDatos->id,
            'pregunta' => 'Nombre del Evaluado',
            'tipo_respuesta' => 'select',
            'requerida' => true,
            'orden' => 1,
            'evaluador_asociado' => true,
            'opciones' => json_encode(['tipo_evaluador' => 'delegados'])
        ]);

        PreguntaEncuesta::create([
            'seccion_encuesta_id' => $seccionDatos->id,
            'seccion_id' => $seccionDatos->id,
            'pregunta' => 'Comisión Técnica de la Municipalidad',
            'tipo_respuesta' => 'text',
            'requerida' => true,
            'orden' => 2
        ]);

        PreguntaEncuesta::create([
            'seccion_encuesta_id' => $seccionDatos->id,
            'seccion_id' => $seccionDatos->id,
            'pregunta' => 'Período de Evaluación',
            'tipo_respuesta' => 'text',
            'requerida' => true,
            'orden' => 3,
            'opciones' => json_encode(['placeholder' => 'Ej: Enero 2023 - Marzo 2023'])
        ]);

        // Sección 2: Conocimiento para Evaluar
        $seccionConocimiento = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => '1. CONOCIMIENTO PARA EVALUAR',
            'orden' => 2
        ]);

        PreguntaEncuesta::create([
            'seccion_encuesta_id' => $seccionConocimiento->id,
            'seccion_id' => $seccionConocimiento->id,
            'pregunta' => '1.1 Dominio de normativa',
            'tipo_respuesta' => 'nivel_desempeno',
            'requerida' => true,
            'orden' => 1,
            'opciones' => json_encode([
                'niveles' => [
                    'Presenta dificultad',
                    'Estado promedio',
                    'Logra excelencia'
                ]
            ])
        ]);

        // Continuar con las demás preguntas siguiendo el mismo patrón...
    }
}
