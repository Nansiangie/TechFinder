<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UtilisateurTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    //public function test_example(): void
    //{
        //$response = $this->get('/');

        //$response->assertStatus(200);
    //}

     public function test_utilisateur_list()
    {
       $response=$this->get('/api/utilisateurs');
       $response->assertStatus(500);

    }
}
