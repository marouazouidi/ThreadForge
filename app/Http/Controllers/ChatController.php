<?php

namespace App\Http\Controllers;

use App\Ai\Agents\PostGenerator;
use App\Http\Requests\ChatRequest;
use App\Models\Post;
use Laravel\Ai\Messages\Message;

class ChatController extends Controller
{
    public function store(Post $post, ChatRequest $request)
    {
        $agent = new PostGenerator;

        $context = "I am asking about this post:\n"
            . "Hook: {$post->hook_propose}\n"
            . "Body Points:\n- " . implode("\n- ", $post->body_points ?? []) . "\n"
            . "Readability Score: {$post->technical_readability_score}\n"
            . "Hashtags: {$post->suggested_hashtag}\n"
            . "Tone Justification: {$post->tone_compliance_justification}\n"
            . "Status: {$post->status->value}";

        $agent->addMessage(new Message('user', $context));

        $response = $agent->prompt($request->question);

        return response()->json([
            'question' => $request->question,
            'data' => $response->toArray(),
        ]);
    }
}
