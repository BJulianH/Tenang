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
        'phone',           // Pastikan ada
        'avatar',          // Pastikan ada
        'role',
        'streak',          // Pastikan ada
        'coins',           // Pastikan ada
        'diamonds',        // Pastikan ada
        'points',          // PASTIKAN ADA - INI YANG DIBUTUHKAN
        'level',           // Pastikan ada
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
        'quests_completed',
        'coins_earned',
        'diamonds_earned',
        'login_streak',
        'perfect_days',
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
        'streak' => 'integer',
        'coins' => 'integer',
        'diamonds' => 'integer',
        'level' => 'integer',
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

    // Relasi journals
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    // TAMBAHAN: Relasi mood trackings untuk MindWell
    public function moodTrackings()
    {
        return $this->hasMany(MoodTracking::class);
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

     public function userQuests()
    {
        return $this->hasMany(UserQuest::class);
    }

    public function todayQuests()
    {
        return $this->hasMany(UserQuest::class)->forToday();
    }
public function hasSocialLinks()
{
    return $this->facebook_url || 
           $this->twitter_url || 
           $this->instagram_url || 
           $this->linkedin_url || 
           $this->github_url;
}
public function addPoints($amount)
    {
        $this->increment('points', $amount);
        return $this;
    }

    // Method untuk menambah coins
    public function addCoins($amount)
    {
        $this->increment('coins', $amount);
        return $this;
    }

    // Method untuk menambah diamonds
    public function addDiamonds($amount)
    {
        $this->increment('diamonds', $amount);
        return $this;
    }

    // Method untuk menambah streak
    public function addStreak()
    {
        $this->increment('streak');
        return $this;
    }

    // Method untuk reset streak
    public function resetStreak()
    {
        $this->update(['streak' => 0]);
        return $this;
    }

    // Method untuk level up
    public function levelUp()
    {
        $this->increment('level');
        return $this;
    }
    // Di Model User yang sudah ada, tambahkan:

// Relasi tasks
public function tasks()
{
    return $this->hasMany(Task::class);
}

// Relasi task preferences
public function taskPreferences()
{
    return $this->hasOne(UserTaskPreferences::class);
}

// Relasi task completions (history)
public function taskCompletions()
{
    return $this->hasMany(TaskCompletion::class);
}

// Relasi task templates
public function taskTemplates()
{
    return $this->hasMany(TaskTemplate::class);
}

// Method untuk mendapatkan tugas hari ini
public function getTodayTasks()
{
    return $this->tasks()->dueToday()->active()->get();
}

// Method untuk mendapatkan tugas overdue
public function getOverdueTasks()
{
    return $this->tasks()->overdue()->get();
}

// Method untuk mendapatkan statistik tasks
public function getTaskStatistics()
{
    $total = $this->tasks()->count();
    $completed = $this->tasks()->where('status', 'completed')->count();
    $pending = $this->tasks()->active()->count();
    $streak = $this->task_streak;
    
    return [
        'total' => $total,
        'completed' => $completed,
        'pending' => $pending,
        'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
        'streak' => $streak,
    ];
}

// Method untuk membuat task dari template
public function createTaskFromTemplate($templateId, $dueDate = null, $dueTime = null)
{
    $template = TaskTemplate::findOrFail($templateId);
    
    if (!$template->is_public && $template->user_id !== $this->id) {
        throw new \Exception('Template tidak tersedia');
    }
    
    return $template->createTask($this->id, $dueDate, $dueTime);
}
}