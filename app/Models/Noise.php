<?php
// app/Models/Noise.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Noise extends Model
{
    use HasFactory;

    protected $fillable = [
        'noise_type_id', 'title', 'slug', 'description', 'audio_file', 
        'duration', 'is_loop', 'is_premium', 'play_count', 'volume_level', 'tags', 'is_active'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_loop' => 'boolean',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function type()
    {
        return $this->belongsTo(NoiseType::class, 'noise_type_id');
    }

    public function useCases()
    {
        return $this->belongsToMany(UseCase::class, 'noise_use_case')
                    ->withPivot('effectiveness_rating')
                    ->withTimestamps();
    }

    // Tambahkan scopes yang diperlukan
    public function scopeApproved($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('play_count', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('play_count', 'desc');
    }
}