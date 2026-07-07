<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hook_propose' => $this->hook_propose,
            'body_points' => $this->body_points,
            'technical_readability_score' => $this->technical_readability_score,
            'suggested_hashtag' => $this->suggested_hashtag,
            'tone_compliance_justification' => $this->tone_compliance_justification,
            'status' => $this->status,
        ];
    }
}
