<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberRequest extends Model
{
    use HasFactory;

    protected $table = 'member_requests';

    protected $fillable = [
        'FName',
        'SName',
        'TName',
        'LName',
        'household_id',
        'PersonId',
        'relation',
        'BirthDate',
        'health_status',
        'desc_health_status_member',
        'identity_image',
        'birth_certificate',
        'household_id_image',
        'status',
        'reviewed_by',
        'reviewed_at',
        'reject_reason',
    ];

    protected $casts = [
        'BirthDate' => 'date',
        'reviewed_at' => 'datetime',
    ];
}
