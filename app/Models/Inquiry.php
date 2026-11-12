<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'course_id',
        'centre_id',
        'mou_partner_id',
        'referral_code_entered',
        'message',
        'status',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'referrer_url',
        'ip',
        'user_agent',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }

    public function mouPartner(): BelongsTo
    {
        return $this->belongsTo(MouPartner::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }
}

