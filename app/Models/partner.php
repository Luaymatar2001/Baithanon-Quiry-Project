<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner extends Model
{
    use HasFactory;
    protected $fillable = [
        'PersonId',
        'FName',
        'SName',
        'TName',
        'LName',
        'relationship',
        'householdId',
        'health_Status',
        'birthdate',
        'desc_health_status'
    ];

    public function household()
    {
        return $this->belongsTo(household::class, 'householdId', 'PersonId');
    }
}
