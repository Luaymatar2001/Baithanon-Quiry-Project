<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class household extends Model
{
    use HasFactory;
    protected $table = 'heads_households';

    protected $primaryKey = 'id'; // ✅ اتركه id
    public $incrementing = true;
    protected $fillable = [
        'PersonId',
        'FName',
        'SName',
        'TName',
        'LName',
        'BirthDate',
        'Gender',
        'Phone_Number',
        'num_Family_Members',
        'legal_confirmation',
        'status',
        'cityId',
        'location_id',
        'governorate_id',
        'Date_partner_martyrdom',
        'health_Status',
        'Sources_income',
        'address',
        'Notes',
    ];
    protected $guarded = [];
    public function city()
    {
        return $this->belongsTo(city::class, 'cityId', 'id');
    }
    public function partner()
    {
        return $this->hasMany(partner::class, 'householdId', 'PersonId');
    }
    // Define relationships if needed
    public function children()
    {
        return $this->hasMany(head_children::class, 'householdId', 'PersonId');
    }
    public function governorate()
    {
        return $this->belongsTo(governorates::class, 'governorate_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(location::class, 'location_id', 'id');
    }
}
