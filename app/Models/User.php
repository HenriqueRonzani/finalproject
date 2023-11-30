<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\DirectMessage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use App\Models\LikesPost;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pfp',
        'bannedUntil',
        'userType',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    protected $dates = ['bannedUntil'];
    
    public function toSearchableArray(): array
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedPosts()
    {
        return $this->morphedByMany(Post::class, 'likable', 'likes');
    }

    public function likedComments()
    {
        return $this->morphedByMany(Comment::class, 'likable', 'likes');
    }

    
    
    public function sentMessages()
    {
        return $this->hasMany(DirectMessage::class, 'SENDER_ID', 'ID_USER');
    }

    public function receivedMessages()
    {
        return $this->hasMany(DirectMessage::class, 'RECEIVER_ID', 'ID_USER');
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user1_id', 'id')
                    ->orWhere('user2_id', $this->id);
    }

    public function getConversationUsers()
    {
        $conversations = $this->conversations()->get();

        $userIds = $conversations->pluck('user1_id')->merge($conversations->pluck('user2_id'))->unique();

        return User::whereIn('id', $userIds)->where('id', '!=', $this->id)->get();
    }

    public function getotherUsers()
    {
        $conversations = $this->conversations()->get();

        $userIds = $conversations->pluck('user1_id')->merge($conversations->pluck('user2_id'))->unique();

        return User::whereNotIn('id', $userIds)->where('id', '!=', $this->id)->orderBy('name')->get();
    }

    public function getconversationsbetweenusers($user1Id, $user2Id)
    {
        return Conversation::where(function ($query) use ($user1Id, $user2Id) {
            $query->where('user1_id', $user1Id)
                  ->where('user2_id', $user2Id);
        })
        ->orWhere(function ($query) use ($user1Id, $user2Id) {
            $query->where('user1_id', $user2Id)
                  ->where('user2_id', $user1Id);
        })
        ->get();
    }
}
