<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'contact_person',
        'phone',
        'email',
        'message',
        'status',
    ];

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
