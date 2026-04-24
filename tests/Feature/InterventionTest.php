<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InterventionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');
    //     $response->assertStatus(200);
    // }

    public function test_intervention_list()
    {
       $response=$this->get('/api/interventions');
       $response->assertStatus(500);

    }

    public function test_intervention_creation()
    {
        $data = [
            'code_int' => 1,
            'libelle_int' => 'Test Intervention',
        ];

        $response = $this->post('/api/interventions', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('intervention', $data);
    }

    public function test_intervention_creation_validation()
    {
        $data = [
            'code_int' => null,
            'libelle_int' => null,
        ];

        $response = $this->post('/api/interventions', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['code_int', 'libelle_int']);
    }

    public function test_intervention_creation_duplicate()
    {
        $data = [
            'code_int' => 1,
            'libelle_int' => 'Test Intervention',
        ];

        // Create the first intervention
        $this->post('/api/interventions', $data);

        // Attempt to create a duplicate intervention
        $response = $this->post('/api/interventions', $data);
        $response->assertStatus(500);
    }

    public function test_intervention_show()
    {
        $intervention = intervention::factory()->create();

        $response = $this->get("/api/interventions/{$intervention->code_int}");
        $response->assertStatus(200);
        $response->assertJson([
            'code_int' => $intervention->code_int,
            'libelle_int' => $intervention->libelle_int,
        ]);
    }
}
