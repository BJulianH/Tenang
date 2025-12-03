<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'category',
        'points',
        'coins',
        'diamonds',
        'max_completions',
        'is_active',
        'is_repeatable',
        'required_progress',
        'requirements'
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'is_repeatable' => 'boolean',
        'required_progress' => 'integer'
    ];

    public function userQuests()
    {
        return $this->hasMany(UserQuest::class);
    }

    // Scope for active quests
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope by type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Get quests for today
    public function scopeForToday($query)
    {
        return $query->active();
    }

    // Get random quests for user
    public function scopeRandomForUser($query, $user, $count = 5)
    {
        return $query->active()
            ->inRandomOrder()
            ->limit($count);
    }
}