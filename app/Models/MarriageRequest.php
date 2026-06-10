<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageRequest extends Model
{
    use HasFactory;

    protected $table = 'marriage_requests';

    protected $fillable = [
        'household_id',

        'FName_h',
        'SName_h',
        'TName_h',
        'LName_h',
        'IdNumHouseHold_h',
        'BirthDate_h',
        'MobailNumber_h',

        'FName_w',
        'SName_w',
        'TName_w',
        'LName_w',
        'IdNumWifeId',
        'BirthDate_w',

        'husband_national_id_image',
        'wife_national_id_image',
    ];

    protected $casts = [
        'BirthDate_h' => 'date',
        'BirthDate_w' => 'date',
    ];

    public function getHusbandFullNameAttribute()
    {
        return trim(collect([
            $this->FName_h,
            $this->SName_h,
            $this->TName_h,
            $this->LName_h,
        ])->filter()->implode(' '));
    }

    public function getWifeFullNameAttribute()
    {
        return trim(collect([
            $this->FName_w,
            $this->SName_w,
            $this->TName_w,
            $this->LName_w,
        ])->filter()->implode(' '));
    }
}
