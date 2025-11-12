<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodRate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rate', 'note', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

