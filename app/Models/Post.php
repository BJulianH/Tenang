<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
        'community_id',
        'mood',
        'is_anonymous',
        'content_type',
        'is_support_request',
        'tags',
        'upvotes_count',
        'downvotes_count',
        'comments_count',
        'saves_count',
        'share_count',
        'view_count',
        'is_approved',
        'is_featured',
        'featured_until'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_anonymous' => 'boolean',
        'is_support_request' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function likes()
    {
        return $this->votes()->where('type', 'upvote');
    }

    public function saves()
    {
        return $this->hasMany(SavedPost::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

public function reports()
{
    return $this->morphMany(Report::class, 'reportable');
}

    // Cek apakah user sudah like post ini
    public function isLikedBy(User $user)
    {
        return $this->votes()
                    ->where('user_id', $user->id)
                    ->where('type', 'upvote')
                    ->exists();
    }

    // Cek apakah user sudah save post ini
    public function isSavedBy(User $user)
    {
        return $this->saves()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    // Scope untuk feed user
    public function scopeForFeed($query, User $user)
    {
        return $query->whereIn('community_id', $user->communities()->pluck('communities.id'))
                    ->orWhere('user_id', $user->id)
                    ->with(['user', 'community', 'votes', 'comments.user'])
                    ->withCount(['votes as upvotes_count' => function($query) {
                        $query->where('type', 'upvote');
                    }])
                    ->withCount(['votes as downvotes_count' => function($query) {
                        $query->where('type', 'downvote');
                    }])
                    ->withCount(['comments'])
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk posts yang butuh support
    public function scopeSupportRequests($query)
    {
        return $query->where('is_support_request', true)
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk posts berdasarkan mood
    public function scopeByMood($query, $mood)
    {
        return $query->where('mood', $mood)
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk featured posts
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where(function($q) {
                        $q->whereNull('featured_until')
                          ->orWhere('featured_until', '>', now());
                    })
                    ->where('is_approved', true)
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk anonymous posts
    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    // Accessor untuk excerpt
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    // Accessor untuk mood dengan icon
    public function getMoodWithIconAttribute()
    {
        $moodIcons = [
            'happy' => '😊',
            'calm' => '😌',
            'anxious' => '😰',
            'sad' => '😢',
            'angry' => '😠',
            'neutral' => '😐'
        ];

        return $moodIcons[$this->mood] . ' ' . ucfirst($this->mood);
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getIsCurrentlyFeaturedAttribute()
    {
        return $this->is_featured && 
               (!$this->featured_until || $this->featured_until->gt(now()));
    }
}