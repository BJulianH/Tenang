<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mood',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk warna mood
    public function getMoodColorAttribute()
    {
        $colors = [
            'senang' => 'bg-green-100 text-green-800 border-green-200',
            'sedih' => 'bg-blue-100 text-blue-800 border-blue-200',
            'cemas' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'stress' => 'bg-red-100 text-red-800 border-red-200',
            'tenang' => 'bg-teal-100 text-teal-800 border-teal-200',
            'marah' => 'bg-orange-100 text-orange-800 border-orange-200',
            'lelah' => 'bg-gray-100 text-gray-800 border-gray-200',
        ];

        return $colors[$this->mood] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    }

    // Accessor untuk icon mood
    public function getMoodIconAttribute()
    {
        $icons = [
            'senang' => 'fas fa-smile-beam',
            'sedih' => 'fas fa-frown',
            'cemas' => 'fas fa-flushed',
            'stress' => 'fas fa-dizzy',
            'tenang' => 'fas fa-smile',
            'marah' => 'fas fa-angry',
            'lelah' => 'fas fa-tired',
        ];

        return $icons[$this->mood] ?? 'fas fa-smile';
    }
}