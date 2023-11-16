<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id',
    ];
    protected $table = 'direct_messages';

    public function sender()
    {
        return $this->belongsTo(User::class, 'SENDER_ID', 'ID_USER');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'RECEIVER_ID', 'ID_USER');
    }
}
