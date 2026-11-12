<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function centres(): HasMany
    {
        return $this->hasMany(Centre::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function mouPartners(): BelongsToMany
    {
        return $this->belongsToMany(MouPartner::class, 'mou_partner_brand');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isFsEducation(): bool
    {
        return $this->slug === 'fs-education';
    }

    public function isFranchise(): bool
    {
        return in_array($this->slug, ['aptech', 'arena-multimedia'], true);
    }
}
