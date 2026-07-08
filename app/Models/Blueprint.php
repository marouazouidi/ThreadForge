<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'tone',
        'max_characters',
        'max_hashtags',
        'rules',
        'user_id',
    ];

    protected $casts = [
        'rules' => 'array',
    ];  

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rawContents(){
        return $this->hasMany(RawContent::class);
    }
}
