<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type_id',
        'title',
        'report_count'
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
    /*
    public function likes(): HasMany
    {
        return $this->hasmany(LikesPost::class);
    }
    */

    public function hasLiked(Post $post): bool
    {
        $user = auth()->user();

        return $user->likes->where('likable_id', $post->id)->where('likable_type', get_class($post))->isNotEmpty();
    }
    
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
