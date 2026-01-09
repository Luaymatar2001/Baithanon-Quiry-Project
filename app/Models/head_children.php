<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class head_children extends Model
{
    use HasFactory;
    
    protected $table = 'heads_children';

    protected $fillable = [
        'PersonId',
        'FName',
        'SName',
        'TName',
        'LName',
        'MotherName',
        'BirthDate',
        'Gender',
        'relationship',
        'health_Status',
        'householdId',
        'MotherId',
    ];

    protected $appends = ['relation_title'];

    public function getRelationTitleAttribute()
    {
        if ($this->Gender === 'ذكر') {
            return 'ابن';
        } elseif ($this->Gender === 'أنثى') {
            return 'ابنة';
        } else {
            return '';
        }
    }
    // Define relationships if needed
    public function father()
    {
        return $this->belongsTo(household::class, 'FatherId', 'PersonId');
    }
    public function mother()
    {
        return $this->belongsTo(household::class, 'MotherId', 'PersonId');
    }
}
