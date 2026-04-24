<?php

namespace Tests\Feature;

use App\Models\Competence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
class CompetenceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_competence_list()
    {
       $response=$this->get('/api/competences');
       $response->assertStatus(200);

    }

    public function test_competence_creation()
    {
        $data = Competence::factory()->make()->toArray();
        $response = $this->post('/api/competences', $data);
        $response->assertStatus(201);
    }

        public function test_competence_creation_validation()
        {
            $data = Competence::factory()->make([
                'code_comp' => null,
                'libelle_comp' => null,
            ])->toArray();

            $response = $this->post('/api/competences', $data);
            $response->assertStatus(200);
            $response->assertJsonValidationErrors(['code_comp', 'libelle_comp']);
        }

        public function test_competence_creation_duplicate()
        {
            $data =Competence::factory()->make()->toArray();

            // Create the first competence
            $this->post('/api/competences', $data);

            // Attempt to create a duplicate competence
            $response = $this->post('/api/competences', $data);
            $response->assertStatus(200);
        }

        public function test_competence_show()
        {
            $competence = Competence::factory()->create();

            $response = $this->get("/api/competences/{$competence->code_comp}");
            $response->assertStatus(200);
            $response->assertJson([
                'code_comp' => $competence->code_comp,
                'libelle_comp' => $competence->libelle_comp,
            ]);
        }

        public function test_competence_update()
        {
            $competence = Competence::factory()->create();
            $data = Competence::factory()->make()->toArray();
            $response = $this->put("/api/competences/{$competence->code_comp}", $data);
            $response->assertStatus(200);
        }

        public function test_competence_delete()
        {
            $competence = Competence::factory()->create();
            $response = $this->delete("/api/competences/{$competence->code_comp}");
            $response->assertStatus(200);
        }

}
