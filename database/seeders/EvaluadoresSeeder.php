<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluadore;
use App\Models\Expediente;

class EvaluadoresSeeder extends Seeder
{
    public function run()
    {
        // Presidentes
        Evaluadore::create([
            'nombre' => 'Juan Pérez',
            'numero_cap' => 'CAP-12345',
            'tipo' => 'presidente',
            'id_usuario_inserta' => '1'
            
        ]);

        // Delegados
        Evaluadore::create([
            'nombre' => 'María Gómez',
            'numero_cap' => 'CAP-54321',
            'tipo' => 'delegado',
            'id_usuario_inserta' => '1'
        ]);

        // Especialistas
        Evaluadore::create([
            'nombre' => 'Carlos Ruiz',
            'numero_cap' => 'CAP-98765',
            'tipo' => 'especialista',
            'especialidad' => 'Seguridad contra incendios',
            'id_usuario_inserta' => '1'
        ]);

        // Ad Hoc
        Evaluadore::create([
            'nombre' => 'Laura Méndez',
            'numero_cap' => 'CAP-56789',
            'tipo' => 'ad_hoc',
            'id_usuario_inserta' => '1'
        ]);

        // Expediente de prueba
        Expediente::create([
            'numero_expediente' => 'EXP-2023-001',
            'municipalidad_tramite' => 'Municipalidad de Lima',
            'fecha_entrevista' => '2023-06-15',
            'presidente_comision' => 1,
            'delegado1' => 2,
            'delegado2' => null,
            'especialista' => 3,
            'delegado_ad_hoc' => 4,
            'id_usuario_inserta' => '1'
        ]);
    }
}