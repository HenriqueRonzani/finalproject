<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    
    protected $fillable = [
            'user_id',
            'status',
            'reportable_id',
            'reportable_type'
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
