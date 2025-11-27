<?php
// app/Models/UseCase.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UseCase extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'sort_order'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function noises()
    {
        return $this->belongsToMany(Noise::class, 'noise_use_case')
                    ->withPivot('effectiveness_rating')
                    ->withTimestamps();
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
    
}