<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Topicality;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class apiTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_api_returns_topicality_list(): void
    {
        $user = User::factory()->create();
        $topicalities = Topicality::factory()->create();
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/topicality');
        $response->assertJson([$topicalities->toArray()]);
        $response->assertStatus(200);
    }
    
    public function test_api_store_topicality_and_returns_successfull():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/topicality',[
            'title' => 'super title',
            'content' => 'content super title'
        ]);
        
        $response->assertJson([
            'success' => 'votre actualité a bien été crée avec succés'
        ]);
    }
    
    public function test_topicality_invalid_returns_errors():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $topicalities = [
            'title' => '',
            'content' => 'super second title'
        ];
        $response = $this->postJson('/api/topicality',$topicalities);

        $response->assertStatus(422);

    }

    public function test_returns_topicality():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $topicalities = Topicality::factory()->create();

        $response = $this->getJson('/api/topicality/' . $topicalities->id);

        $response->assertJson($topicalities->toArray());
    }

    public function test_returns_error_id_invalid():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/topicality/1');

        $response->assertStatus(404);

    }

    public function test_update_topicality_invalid_returns_errors():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $topicalities = [
            'title' => 'super title',
            'content' => ''
        ];

        Topicality::factory()->create();

        $response = $this->putJson('/api/topicality/1',$topicalities);

        $response->assertStatus(422);
    }

    public function test_update_topicality_returns_successfull():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $topicalities = [
            'title' => 'super title édité',
            'content' => 'content super title édité'
        ];

        Topicality::factory()->create();

        $response = $this->putJson('/api/topicality/1',$topicalities);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'votre actualité a bien été modifiée avec succés'
        ]);

        $this->assertDatabaseHas('topicalities',$topicalities);
        $this->assertDatabaseCount('topicalities',1);
    }

    public function test_destroy_topicality_returns_successfull():void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $topicalities = Topicality::factory()->create();

        $response = $this->deleteJson('/api/topicality/' . $topicalities->id);

        $response->assertJson([
            'success' => 'votre actualité a bien été supprimé avec succés'
        ]);

        $this->assertDatabaseEmpty('topicalities');
    }
    
}
