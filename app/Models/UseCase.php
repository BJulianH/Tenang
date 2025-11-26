<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'sort_order'];

    public function noises()
    {
        return $this->belongsToMany(Noise::class, 'noise_use_case')
                    ->withPivot('effectiveness_rating')
                    ->withTimestamps();
    }
}