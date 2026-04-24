<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class User_CompetenceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    //public function test_example(): void
    //{
        //$response = $this->get('/');

        //$response->assertStatus(200);
    //}

    public function test_user_competence_list()
    {
       $response=$this->get('/api/user_competences');
       $response->assertStatus(404);

    }

    public function test_user_competence_creation()
    {
        $data = [
            'user_id' => 1,
            'competence_id' => 1,
        ];

        $response = $this->post('/api/user_competences', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('user_competence', $data);
    }

    public function test_user_competence_creation_validation()
    {
        $data = [
            'user_id' => null,
            'competence_id' => null,
        ];

        $response = $this->post('/api/user_competences', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['user_id', 'competence_id']);
    }

    public function test_user_competence_creation_duplicate()
    {
        $data = [
            'user_id' => 1,
            'competence_id' => 1,
        ];

        // Create the first user_competence
        $this->post('/api/user_competences', $data);

        // Attempt to create a duplicate user_competence
        $response = $this->post('/api/user_competences', $data);
        $response->assertStatus(409);
    }
}
