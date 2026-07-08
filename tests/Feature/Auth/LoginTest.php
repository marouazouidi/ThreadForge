<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('returns a token when the creadentials are valid', function (){
    
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email'=> $user->email,
        'password' => 'password',
    ]);

    $response 
        ->assertJsonStructure([
            'token',
        ])
        ->assertStatus(500);
});

test('return 401 when the password is invalid', function(){

    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    $response
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Invalid credentials',
        ]);
});