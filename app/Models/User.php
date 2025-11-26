<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'profile_image',
        'cover_image',
        'website',
        'location',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'github_url',
        'date_of_birth',
        'gender',
        'role',
        'account_type',
        'is_verified',
        'is_active',
        'is_online',
        'show_email',
        'show_date_of_birth',
        'profile_visibility',
        'reputation_score',
        'post_count',
        'comment_count',
        'follower_count',
        'following_count',
        'timezone',
        'locale',
        'notification_settings',
        'preferences',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_online' => 'boolean',
        'show_email' => 'boolean',
        'show_date_of_birth' => 'boolean',
        'notification_settings' => 'array',
        'preferences' => 'array',
    ];

    // Relasi ke communities yang dimiliki (sebagai creator)
    public function ownedCommunities()
    {
        return $this->hasMany(Community::class, 'creator_id');
    }

    // Relasi ke communities yang diikuti
    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_user')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    // Relasi posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relasi comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Scope untuk admin
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Scope untuk moderator
    public function scopeModerators($query)
    {
        return $query->where('role', 'moderator');
    }

    // Scope untuk user aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk user verified
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah moderator
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Update last login
    public function updateLastLogin()
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }

    // Accessor untuk age
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    // Accessor untuk display name
    public function getDisplayNameAttribute()
    {
        return $this->username ? '@' . $this->username : $this->name;
    }
}