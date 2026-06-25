<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'hook_propose',
        'body_points',
        'technical_readability_score',
        'suggested_hashtag',
        'tone_compliance_justification',
        'payload_brut',
        'status',
        'raw_content_id',
    ];

    protected function casts(){
        return [
            'status' => PostStatus::class,
            'body_points' => 'array',
            'payload_brut' => 'array',
        ];
    }

    public function rawContent(){
        return $this->belongsTo(RawContent::class);
    }
}
