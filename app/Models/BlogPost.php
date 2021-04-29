<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BlogPost extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'title',
        'content'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
