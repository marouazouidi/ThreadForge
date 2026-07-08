<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('blueprint validation fails when required field is missing', function () {

    // Arrange
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    // Act
    $response = $this->postJson('/api/blueprints', [
        'tone' => 'Professional',
        'max_characters' => 300,
        'max_hashtags' => 5,
        'rules' => [
            'Use simple language',
            'End with a CTA',
        ],
    ]);

    // Assert
    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'name',
        ]);
});