<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuesta;
use App\Models\SeccionEncuesta;
use App\Models\PreguntaEncuesta;

class EncuestasSeeder extends Seeder
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
            'descripcion' => 'Encuesta para evaluar el desempeño de los evaluadores',
            'activa' => true
        ]);
        $seccion = SeccionEncuesta::create([
            'encuesta_id' => $encuesta->id,
            'titulo' => 'Opinión Técnica y Normativa',
            'descripcion' => 'Califique los aspectos técnicos',
            'orden' => 1
        ]);
        
        PreguntaEncuesta::create([
            'seccion_id' => $seccion,
            'pregunta' => 'Las observaciones tenían sustento normativo específico',
            'tipo_respuesta' => 'rango',
            'requerida' => true,
            'orden' => 1,
            'opciones' => [
                'min' => 1,
                'max' => 5,
                'default' => 3
            ]
        ]);
    }
}
