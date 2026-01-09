<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    use HasFactory;

    protected $table = 'city';
    protected $fillable = [
        'name',
    ];

    // Define relationship to Location
    public function locations()
    {
        return $this->hasMany(location::class, 'city_id');
    }
}
