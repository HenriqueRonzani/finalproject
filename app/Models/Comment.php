<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;


    protected $fillable = [
        'message',
        'code',
        'post_id',
        'type_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): Belongsto
    {
        return $this->belongsTo(Post::class);
    }

    public function hasLiked(Comment $comment): bool
    {
        $user = auth()->user();

        return $user->likes->where('likable_id', $comment->id)->where('likable_type', get_class($comment))->isNotEmpty();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function reports(){
        return $this->morphMany(Report::class, 'reportable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
