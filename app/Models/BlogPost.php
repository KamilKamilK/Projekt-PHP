<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;

class BlogPost extends Model
{
    use HasFactory,Notifiable;

    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // Local query scope
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }
    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope); // <- Global scope

        parent::boot();

        static::deleting(function(BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::restoring(function(BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }
}
