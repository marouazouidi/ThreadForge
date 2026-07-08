<?php

use App\Jobs\GeneratePostJob;
use App\Models\Blueprint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('raw content generation is dispatched asynchronously', function () {

    // Fake the queue
    Queue::fake();

    // Create user
    $user = User::factory()->create();

    // Authenticate user
    Sanctum::actingAs($user);

    // Create blueprint
    $blueprint = Blueprint::factory()->create([
        'user_id' => $user->id,
    ]);

    // Send request
    $response = $this->postJson('/api/raw-content', [
        'content' => 'Laravel AI SDK is amazing.',
        'blueprint_id' => $blueprint->id,
    ]);

    // Response
    $response
        ->assertStatus(202)
        ->assertJsonFragment([
            'message' => 'Raw content submitted successfully. Generation started.',
        ]);

    // Verify job dispatched
    Queue::assertPushed(GeneratePostJob::class);

});