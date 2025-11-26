<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NoiseType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color_code', 'description', 'sort_order', 'is_active'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function noises()
    {
        return $this->hasMany(Noise::class);
    }
}