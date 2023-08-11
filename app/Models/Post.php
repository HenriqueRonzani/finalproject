<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type',
    ];


    public function types(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function users(): Belongsto
    {
        return $this->belongsTo(User::class);
    }
}
