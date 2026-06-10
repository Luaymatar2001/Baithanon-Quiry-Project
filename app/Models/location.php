<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $table = "locations";
    protected $fillable = [
        'name',
        'city_id',
    ];


    // Define relationship to City
    public function city()
    {
        return $this->belongsTo(city::class, 'city_id');
    }
}
