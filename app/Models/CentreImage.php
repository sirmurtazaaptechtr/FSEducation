<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CentreImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'centre_id',
        'path',
        'caption',
        'alt_text',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }
}
