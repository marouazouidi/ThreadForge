<?php

namespace App\Models;

use App\Enums\RawContentStatus;
use Illuminate\Database\Eloquent\Model;

class RawContent extends Model
{
    protected $fillable = [
        'content',
        'status',
        'user_id',
        'blueprint_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => RawContentStatus::class,
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function blueprint(){
        return $this->belongsTo(Blueprint::class);
    }

    public function post(){
        return $this->hasOne(Post::class);
    }
}

