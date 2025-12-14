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
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'update_at' => 'datetime'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk mood icon
    public function getMoodIconAttribute()
    {
        $icons = [
            'senang' => 'fas fa-smile-beam',      // Senyum lebar
            'sedih' => 'fas fa-sad-tear',         // Sedih dengan air mata
            'cemas' => 'fas fa-flushed',          // Cemas
            'stress' => 'fas fa-dizzy',           // Pusing/stress
            'tenang' => 'fas fa-smile',           // Senyum tenang
            'marah' => 'fas fa-angry',            // Marah
            'lelah' => 'fas fa-tired',            // Lelah
        ];

        return $icons[$this->mood] ?? 'fas fa-smile';
    }

    // Accessor untuk mood emoji (jika ingin emoji sebagai alternatif)
    public function getMoodEmojiAttribute()
    {
        $emojis = [
            'senang' => '😊',
            'sedih' => '😢',
            'cemas' => '😰',
            'stress' => '😵',
            'tenang' => '😌',
            'marah' => '😠',
            'lelah' => '😫',
        ];

        return $emojis[$this->mood] ?? '😊';
    }

    // Accessor untuk mood color class
    public function getMoodColorAttribute()
    {
        $colors = [
            'senang' => 'bg-green-100 text-green-800',
            'sedih' => 'bg-blue-100 text-blue-800',
            'cemas' => 'bg-yellow-100 text-yellow-800',
            'stress' => 'bg-red-100 text-red-800',
            'tenang' => 'bg-teal-100 text-teal-800',
            'marah' => 'bg-orange-100 text-orange-800',
            'lelah' => 'bg-gray-100 text-gray-800',
        ];

        return $colors[$this->mood] ?? 'bg-gray-100 text-gray-800';
    }

    // Accessor untuk mood bg color
    public function getMoodBgColorAttribute()
    {
        $colors = [
            'senang' => 'bg-green-100',
            'sedih' => 'bg-blue-100',
            'cemas' => 'bg-yellow-100',
            'stress' => 'bg-red-100',
            'tenang' => 'bg-teal-100',
            'marah' => 'bg-orange-100',
            'lelah' => 'bg-gray-100',
        ];

        return $colors[$this->mood] ?? 'bg-gray-100';
    }

    // Accessor untuk mood text color
    public function getMoodTextColorAttribute()
    {
        $colors = [
            'senang' => 'text-green-600',
            'sedih' => 'text-blue-600',
            'cemas' => 'text-yellow-600',
            'stress' => 'text-red-600',
            'tenang' => 'text-teal-600',
            'marah' => 'text-orange-600',
            'lelah' => 'text-gray-600',
        ];

        return $colors[$this->mood] ?? 'text-gray-600';
    }
}