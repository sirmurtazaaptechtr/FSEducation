<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'course_category_id',
        'affiliation_id',
        'title',
        'slug',
        'short_description',
        'description',
        'duration',
        'eligibility',
        'fee_note',
        'outcomes',
        'image',
        'approval_status',
        'registration_reference',
        'approval_note',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Course $course) {
            // Strict franchisor rule: Aptech and Arena Multimedia courses must NEVER carry an SBTE or NAVTTC affiliation tag.
            if ($course->affiliation_id) {
                $brand = $course->brand ?? Brand::find($course->brand_id);
                if ($brand && $brand->slug !== 'fs-education') {
                    throw new InvalidArgumentException(
                        "Affiliations (SBTE/NAVTTC) are strictly restricted to F.S. Education programmes. Franchise courses (Aptech/Arena Multimedia) cannot carry affiliation tags."
                    );
                }
            }
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function affiliation(): BelongsTo
    {
        return $this->belongsTo(Affiliation::class);
    }

    public function centres(): BelongsToMany
    {
        return $this->belongsToMany(Centre::class, 'centre_course');
    }

    public function mouPartners(): BelongsToMany
    {
        return $this->belongsToMany(MouPartner::class, 'mou_partner_course');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
