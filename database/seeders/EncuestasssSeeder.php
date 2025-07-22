<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuesta;
use App\Models\SeccionEncuesta;
use App\Models\PreguntaEncuesta;

class EncuestasssSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PreguntaEncuesta::create([
            'seccion_encuesta_id' =>1,
            'pregunta' => '¿Qué áreas de mejora identificó en la evaluación?',
            'tipo_respuesta' => 'checkbox',
            'requerida' => true,
            'orden' => 1,
            'opciones' => [
                'documentacion' => 'Documentación incompleta',
                'diseno' => 'Diseño no cumple normativa',
                'calculos' => 'Cálculos estructurales insuficientes',
                'accesibilidad' => 'Problemas de accesibilidad',
                'seguridad' => 'Falta de medidas de seguridad'
            ]
        ]);


        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 1,
            'pregunta' => 'Nivel de satisfacción con el evaluador principal',
            'tipo_respuesta' => 'select',
            'requerida' => true,
            'orden' => 2,
            'opciones' => [
                'excelente' => 'Excelente - Superó expectativas',
                'bueno' => 'Bueno - Cumplió con lo esperado',
                'regular' => 'Regular - Hubo áreas de mejora',
                'deficiente' => 'Deficiente - No cumplió expectativas'
            ]
        ]);


        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 1,
            'pregunta' => 'Califique del 1 al 10 la claridad de las observaciones',
            'tipo_respuesta' => 'numero',
            'requerida' => true,
            'orden' => 3,
            'opciones' => [
                'min' => 1,
                'max' => 10,
                'step' => 1
            ]
        ]);


        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 1,
            'pregunta' => 'Fecha en que recibió los comentarios finales',
            'tipo_respuesta' => 'fecha',
            'requerida' => false,
            'orden' => 4,
            'opciones' => [
                'min' => date('Y-m-d', strtotime('-1 month')),
                'max' => date('Y-m-d')
            ]
        ]);


        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 1,
            'pregunta' => 'Comentarios adicionales sobre el proceso de evaluación',
            'tipo_respuesta' => 'text',
            'requerida' => false,
            'orden' => 5,
            'opciones' => [
                'maxlength' => 500,
                'placeholder' => 'Escriba aquí sus comentarios...'
            ]
        ]);


        PreguntaEncuesta::create([
            'seccion_encuesta_id' => 1,
            'pregunta' => 'Nivel de acuerdo con las observaciones (1: Total desacuerdo - 5: Total acuerdo)',
            'tipo_respuesta' => 'rango',
            'requerida' => true,
            'orden' => 6,
            'opciones' => [
                'min' => 1,
                'max' => 5,
                'default' => 3
            ]
        ]);
    }
}
