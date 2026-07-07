<?php

namespace App\Ai\Tools;

use App\Models\Post;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetPostHistory implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get the full history and metadata of a generated post by its ID, including the original raw content.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'postId' => $schema
                ->integer()
                ->required()
                ->description('The ID of the generated post'),
        ];
    }

    public function handle(Request $request): Stringable|string
    {
        $post = Post::with('rawContent')->findOrFail($request['postId']);

        return collect([
            "Hook: {$post->hook_propose}",
            "Body Points: " . json_encode($post->body_points),
            "Readability Score: {$post->technical_readability_score}",
            "Hashtags: {$post->suggested_hashtag}",
            "Tone Justification: {$post->tone_compliance_justification}",
            "Status: {$post->status->value}",
            "Original Content: {$post->rawContent?->content}",
        ])->implode("\n");
    }
}
