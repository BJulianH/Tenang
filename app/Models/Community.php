<?php
// app/Models/Community.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner_image',
        'profile_image',
        'type',
        'creator_id',
        'parent_id',
        'is_main'
    ];

    // Relasi ke user yang membuat komunitas
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Relasi parent community (untuk sub-komunitas)
    public function parent()
    {
        return $this->belongsTo(Community::class, 'parent_id');
    }

    // Relasi sub-communities
    public function children()
    {
        return $this->hasMany(Community::class, 'parent_id');
    }

    // Relasi many-to-many dengan users (members)
    public function members()
    {
        return $this->belongsToMany(User::class, 'community_user')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    // Relasi posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Scope untuk komunitas utama
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    // Scope untuk sub-komunitas
    public function scopeSubCommunities($query)
    {
        return $query->where('is_main', false);
    }

    // Cek apakah user adalah member
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    // Cek apakah user adalah admin
    public function isAdmin($userId)
    {
        return $this->members()
                    ->where('user_id', $userId)
                    ->where('community_user.role', 'admin')
                    ->exists();
    }
}