<?php
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'parent_id'
    ];

    // protected $with = ['user', 'replies']; // Auto load user dan replies
    // protected $withCount = ['likes', 'replies'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
{
    return $this->hasMany(Comment::class, 'parent_id')
                ->with('user')
                ->withCount([
                    'likes as upvotes_count' => function ($q) {
                        $q->where('type', 'upvote');
                    }
                ])
                ->with('replies'); 
}


    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function likes()
    {
        return $this->votes()->where('type', 'upvote');
    }

    // Cek apakah user sudah like comment ini
    public function isLikedBy($user)
    {
        if (!$user) return false;
        
        return $this->likes()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    // Cek apakah user adalah pemilik comment
    public function isOwnedBy($user)
    {
        if (!$user) return false;
        return $this->user_id === $user->id;
    }

    // Scope untuk comments tanpa parent (comment utama)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessor untuk excerpt
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 100);
    }
    public function reports()
{
    return $this->morphMany(Report::class, 'reportable');
}
}