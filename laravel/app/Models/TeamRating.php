<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'rating',
        'feedback',
        'session_hash',
        'notified',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'notified' => 'boolean',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Scope for ratings not yet included in a digest.
     */
    public function scopeUnnotified($query)
    {
        return $query->where('notified', false);
    }

    /**
     * Scope for negative ratings (1-3 stars).
     */
    public function scopeNegative($query)
    {
        return $query->where('rating', '<=', 3);
    }

    /**
     * Scope for positive ratings (4-5 stars).
     */
    public function scopePositive($query)
    {
        return $query->where('rating', '>=', 4);
    }
}
