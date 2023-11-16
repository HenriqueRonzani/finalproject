<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type_id',
        'title',
    ];


    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function user(): Belongsto
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasmany(LikesPost::class);
    }

    public function hasLiked(Post $postid): bool
    {
        $user = auth()->user();

        return $user->likes->contains('post_id', $postid->id);
    }
}
