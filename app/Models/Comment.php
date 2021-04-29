<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use HasFactory,Notifiable;

    protected $fillable =[
        'content',
        'blog_post_id'
    ];
    // blog_post_id
    public function blogPost()
    {
//        return $this->belongsTo('App\Models\BlogPOst', 'post_id', 'blog_post_id');
        return $this->belongsTo(BlogPost::class);
    }
}
