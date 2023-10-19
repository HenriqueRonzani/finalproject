<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    use HasFactory;

    protected $table = 'directmessage'; // Assuming your table name is 'messages'

    public function sender()
    {
        return $this->belongsTo(User::class, 'SENDER_ID', 'ID_USER');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'RECEIVER_ID', 'ID_USER');
    }
}