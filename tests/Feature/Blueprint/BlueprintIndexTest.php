<?php
use App\Models\Blueprint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
uses(RefreshDatabase::class);

test('guest cannot access blueprints endpoint', function(){

    $response = $this->getJson('/api/blueprints');

    $response->assertUnauthorized(); // assertStatus(401)
});

test('authenticated user can access blueprints endpoint', function(){

    $user = User::factory()->create();

    Blueprint::factory()->count(2)->create([
        'user_id' => $user->id,
    ]);

    Sanctum::actingAs($user);

    $response = $this->getJson('/api/blueprints');

    $response
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'max_characters',
                    'max_hashtags',
                    'rules',
                ],
            ],
        ])
        ->assertOk(); // assertStatus(200)
});