<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'likable_id',
        'likable_type'
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
