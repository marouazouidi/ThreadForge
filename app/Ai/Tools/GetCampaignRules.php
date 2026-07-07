<?php

namespace App\Ai\Tools;

use App\Models\Blueprint;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCampaignRules implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get the campaign rules for a given campaign ID, including tone, character limits, hashtag limits and writing rules.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaignId' => $schema
                ->integer()
                ->required()
                ->description('The ID of the campaign blueprint'),
        ];
    }

    public function handle(Request $request): Stringable|string
    {
        $blueprint = Blueprint::findOrFail($request['campaignId']);

        return collect([
            "Name: {$blueprint->name}",
            "Tone: {$blueprint->tone}",
            "Max Characters: {$blueprint->max_characters}",
            "Max Hashtags: {$blueprint->max_hashtags}",
            "Rules: " . json_encode($blueprint->rules),
        ])->implode("\n");
    }
}
