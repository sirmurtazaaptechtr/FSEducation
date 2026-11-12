<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MouPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'organization_type',
        'short_description',
        'description',
        'website_url',
        'signed_on',
        'valid_from',
        'valid_until',
        'discount_type',
        'discount_value',
        'discount_label',
        'terms',
        'how_to_avail',
        'referral_code',
        'is_featured',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'signed_on' => 'date',
            'valid_from' => 'date',
            'valid_until' => 'date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'mou_partner_brand');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'mou_partner_course');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Scope for active and valid MOUs. Expired or scheduled MOUs are excluded automatically.
     */
    public function scopeActive($query)
    {
        $today = Carbon::today();

        return $query->where('is_active', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('valid_from')
                  ->orWhere('valid_from', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', $today);
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Determine computed status badge: Active, Scheduled, Expired, or Inactive.
     */
    public function getStatusAttribute(): string
    {
        if (! $this->is_active) {
            return 'Inactive';
        }

        $today = Carbon::today();

        if ($this->valid_from && $this->valid_from->isAfter($today)) {
            return 'Scheduled';
        }

        if ($this->valid_until && $this->valid_until->isBefore($today)) {
            return 'Expired';
        }

        return 'Active';
    }

    public function isValidNow(): bool
    {
        return $this->status === 'Active';
    }
}
