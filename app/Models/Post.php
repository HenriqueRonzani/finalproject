<?php

namespace App\Models;

use Illuminate\Database\Eloquenta\Relations\Belongsto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'type',
    ];
    
  /*  public function users():Belongsto
    {
        return $this->belongsTo(User::class)
    }
    */
}
