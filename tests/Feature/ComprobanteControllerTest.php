<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Comprobante;

class ComprobanteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/comprobante');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.comprobante.all');
    }

    public function test_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/comprobante', [
            'Trans' => 'FA',
            'id_caja' => 1,
            'TipoF' => 'FTFT',
            'total' => 100.00,
            'factura_detalle' => [
                [
                    'id' => 1,
                    'cantidad' => 1,
                    'monto' => 100.00,
                    'descripcion' => 'Test Item',
                    'id_concepto' => 1,
                ],
            ],
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('comprobantes', [
            'total' => 100.00,
        ]);
    }
}