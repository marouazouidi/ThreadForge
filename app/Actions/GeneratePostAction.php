<?php

namespace App\Actions;

use App\Ai\Agents\PostGenerator;
use App\Models\Blueprint;
use App\Models\RawContent;

class GeneratePostAction
{
    public function execute(RawContent $rawContent, Blueprint $blueprint): array{
        $prompt = "You are an expert LinkedIn Ghostwriter. Campaign Rules:
                    Tone:
                    {$blueprint->tone}

                    Maximum characters:
                    {$blueprint->max_characters}

                    Maximum hashtags:
                    {$blueprint->max_hashtags}

                    Additional Rules:
                    {$blueprint->rules}

                    Raw Content:

                    {$rawContent->content}
                    ";

        $response = (new PostGenerator)->prompt($prompt);

        return $response->toArray();
    }
}
